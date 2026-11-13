<?php

namespace Tests\Feature;

use App\Mail\DriverApplicationSubmittedMail;
use App\Mail\DriverDocumentUploadedMail;
use App\Models\Cars;
use App\Models\DriverDocument;
use App\Models\DriverProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * 1. An active driver with an expired/rejected/missing required document can't
 *    take new jobs (driver-booking), but keeps everything else.
 * 2. The admin inbox gets an email when a driver registers, and when a driver
 *    (not an admin acting for them) uploads or replaces a document.
 */
class DriverJobEligibilityAndNotificationsTest extends TestCase
{
    use DatabaseTransactions;

    private const PDF = "%PDF-1.4\n1 0 obj<< /Type /Catalog >>endobj\ntrailer<< /Root 1 0 R >>\n%%EOF";

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('driver_documents');
    }

    // ---------------------------------------------------------------- helpers

    private function activeDriver(): User
    {
        return User::create([
            'name' => 'Sam Driver', 'email' => Str::random(8) . '@example.test', 'phone' => '07123 456789',
            'password' => 'secret-pass', 'type' => 2, 'status' => 1, 'make' => 'Toyota', 'model' => 'Prius',
        ]);
    }

    private function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => Str::random(8) . '@example.test', 'password' => 'secret-pass', 'type' => 1, 'status' => 1]);
    }

    /** Fills in the driver/bank/vehicle *details* (as opposed to documents) that overall() also checks. */
    private function completeDetails(User $driver): void
    {
        DriverProfile::updateOrCreate(['user_id' => $driver->id], [
            'emergency_contact_name' => 'Pat', 'emergency_contact_phone' => '07000 111222', 'vehicle_year' => 2021,
            'bank_account_holder' => $driver->name, 'bank_account_number' => '12345678', 'bank_sort_code' => '112233', 'bank_name' => 'Bank',
        ]);
    }

    private function requiredTypes(): array
    {
        return array_keys(array_filter(config('driver_documents.types'), fn ($t) => $t['required']));
    }

    /** Every required document approved (and not expiring), so the driver starts fully clear. */
    private function approveEveryRequiredDocument(User $driver): void
    {
        foreach ($this->requiredTypes() as $type) {
            $hasExpiry = config("driver_documents.types.{$type}.has_expiry");
            DriverDocument::create([
                'user_id' => $driver->id, 'type' => $type, 'original_name' => "{$type}.pdf",
                'path' => "x/{$type}.enc", 'mime' => 'application/pdf', 'extension' => 'pdf',
                'size' => 10, 'checksum' => str_repeat('a', 64), 'status' => 'approved', 'uploaded_at' => now(),
                'expiry_date' => $hasExpiry ? now()->addYear() : null,
            ]);
        }
    }

    private function pdf(string $name = 'doc.pdf'): UploadedFile
    {
        return UploadedFile::fake()->createWithContent($name, self::PDF);
    }

    // ------------------------------------------------------- job eligibility

    /** @test */
    public function a_fully_verified_driver_can_browse_and_accept_jobs(): void
    {
        $driver = $this->activeDriver();
        $this->completeDetails($driver);
        $this->approveEveryRequiredDocument($driver);

        $this->actingAs($driver)->get(route('driver-booking.index'))->assertOk();
    }

    /** @test */
    public function an_expired_required_document_blocks_new_jobs_but_not_accepted_ones_or_the_rest_of_the_account(): void
    {
        $driver = $this->activeDriver();
        $this->completeDetails($driver);
        $this->approveEveryRequiredDocument($driver);

        // One required document quietly passes its expiry date - no admin action taken.
        DriverDocument::where('user_id', $driver->id)->where('type', 'phv_vehicle_licence')->update(['expiry_date' => now()->subDay()]);

        $res = $this->actingAs($driver)->get(route('driver-booking.index'));
        $res->assertRedirect(route('driver.docs.index'));
        $res->assertSessionHas('error');
        $this->assertStringContainsString('take new jobs', session('error'));

        // Already-accepted work, account and password are unaffected.
        $this->actingAs($driver)->get(route('driver-accepted-booking.index'))->assertOk();
        $this->actingAs($driver)->get(route('driveraccount'))->assertOk();
        $this->actingAs($driver)->get(route('driverchangepass'))->assertOk();
    }

    /** @test */
    public function a_rejected_required_document_blocks_new_jobs_the_same_way(): void
    {
        $driver = $this->activeDriver();
        $this->completeDetails($driver);
        $this->approveEveryRequiredDocument($driver);
        DriverDocument::where('user_id', $driver->id)->where('type', 'v5c_logbook')
            ->update(['status' => 'rejected', 'rejection_reason' => 'Blurry', 'rejected_at' => now()]);

        $this->actingAs($driver)->get(route('driver-booking.index'))->assertRedirect(route('driver.docs.index'));
        $this->actingAs($driver)->put(route('driver-booking.update', 1))->assertRedirect(route('driver.docs.index'));
    }

    /** @test */
    public function uploading_a_renewed_document_lifts_the_block_straight_away_but_a_rejection_reinstates_it(): void
    {
        $driver = $this->activeDriver();
        $this->completeDetails($driver);
        $this->approveEveryRequiredDocument($driver);
        $expired = DriverDocument::where('user_id', $driver->id)->where('type', 'phv_vehicle_licence')->first();
        $expired->update(['expiry_date' => now()->subDay()]);

        // actingAs() pins one PHP object as the request user for the rest of the
        // test, so it's re-fetched fresh before each check - otherwise its cached
        // driverDocuments relation would go stale the moment we update $expired
        // directly, which a real second HTTP request would never do.
        $this->actingAs($driver->fresh())->get(route('driver-booking.index'))->assertRedirect();

        // Uploading a fresh copy lifts the block immediately - ahead of admin
        // review, by design (see DriverVerificationService::blocksNewJobs()).
        $expired->update(['status' => 'uploaded', 'expiry_date' => null, 'uploaded_at' => now()]);
        $this->actingAs($driver->fresh())->get(route('driver-booking.index'))->assertOk();

        // If the admin then rejects that upload, the driver is blocked again.
        $expired->update(['status' => 'rejected', 'rejection_reason' => 'Still shows the old expiry date', 'rejected_at' => now()]);
        $this->actingAs($driver->fresh())->get(route('driver-booking.index'))->assertRedirect();

        // Approving it for real leaves them unblocked.
        $expired->update(['status' => 'approved', 'rejection_reason' => null, 'expiry_date' => now()->addYear()]);
        $this->actingAs($driver->fresh())->get(route('driver-booking.index'))->assertOk();
    }

    /** @test */
    public function the_documents_page_and_admin_list_show_the_blocked_state(): void
    {
        $driver = $this->activeDriver();
        $this->approveEveryRequiredDocument($driver);
        DriverDocument::where('user_id', $driver->id)->where('type', 'v5c_logbook')->update(['expiry_date' => now()->subDay()]);

        $this->actingAs($driver)->get(route('driver.docs.index'))
            ->assertOk()->assertSee("You can't take new jobs right now", false);

        $this->actingAs($this->admin())->get(route('admin.dv.index'))
            ->assertOk()->assertSee('Blocked from jobs', false);
    }

    // --------------------------------------------------------- notifications

    /** @test */
    public function registering_emails_the_admin_recipients(): void
    {
        Mail::fake();
        $existingAdminAddress = config('mail.admin_recipients')[0] ?? 'sailapritam@gmail.com';

        $data = [
            'first_name' => 'Riley', 'last_name' => 'Applicant', 'email' => Str::random(8) . '@example.test',
            'password' => 'a-long-password', 'phone' => '07123 456789', 'address' => '1 High Street, Leeds',
            'postcode' => 'LS1 4DY', 'vehicleregnumber' => 'AB12 CDE', 'make' => 'Toyota', 'model' => 'Prius',
            'cartype' => Cars::query()->value('id') ?? $this->markTestSkipped('No car types configured.'),
            'checkbox' => 'on',
        ];

        $this->post('/post-driver-register', $data)->assertSessionHasNoErrors();

        $driver = User::where('email', $data['email'])->firstOrFail();

        Mail::assertSent(DriverApplicationSubmittedMail::class, function ($mail) use ($driver, $existingAdminAddress) {
            return $mail->driver->is($driver)
                && $mail->hasTo($existingAdminAddress)
                && str_contains($mail->envelope()->subject, $driver->name);
        });
    }

    /** @test */
    public function a_driver_uploading_their_own_document_emails_the_admin_recipients(): void
    {
        Mail::fake();
        $driver = $this->activeDriver();

        $this->actingAs($driver)->post(route('driver.docs.upload', 'v5c_logbook'),
            ['document' => $this->pdf()], ['Accept' => 'application/json'])->assertOk();

        Mail::assertSent(DriverDocumentUploadedMail::class, function ($mail) use ($driver) {
            return $mail->document->user_id === $driver->id
                && $mail->document->type === 'v5c_logbook'
                && $mail->isReplacement === false;
        });

        // Replacing it fires a second email, flagged as a replacement.
        $this->actingAs($driver)->post(route('driver.docs.upload', 'v5c_logbook'),
            ['document' => $this->pdf('two.pdf')], ['Accept' => 'application/json'])->assertOk();

        Mail::assertSent(DriverDocumentUploadedMail::class, fn ($mail) => $mail->isReplacement === true);
        Mail::assertSent(DriverDocumentUploadedMail::class, 2);
    }

    /** @test */
    public function an_admin_uploading_on_a_drivers_behalf_does_not_email_itself(): void
    {
        Mail::fake();
        $driver = $this->activeDriver();
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.dv.upload', [$driver, 'v5c_logbook']),
            ['document' => $this->pdf()], ['Accept' => 'application/json'])->assertOk();

        Mail::assertNotSent(DriverDocumentUploadedMail::class);
    }

    /** @test */
    public function a_broken_mailer_never_breaks_registration(): void
    {
        Mail::shouldReceive('to')->andReturnSelf();
        Mail::shouldReceive('send')->andThrow(new \Exception('smtp down'));

        $data = [
            'first_name' => 'Riley', 'last_name' => 'Applicant', 'email' => Str::random(8) . '@example.test',
            'password' => 'a-long-password', 'phone' => '07123 456789', 'address' => '1 High Street, Leeds',
            'postcode' => 'LS1 4DY', 'vehicleregnumber' => 'AB12 CDE', 'make' => 'Toyota', 'model' => 'Prius',
            'cartype' => Cars::query()->value('id') ?? $this->markTestSkipped('No car types configured.'),
            'checkbox' => 'on',
        ];

        $this->post('/post-driver-register', $data)->assertRedirect(route('driver.docs.index'));
        $this->assertDatabaseHas('users', ['email' => $data['email']]);
    }
}
