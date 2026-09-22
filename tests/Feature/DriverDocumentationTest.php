<?php

namespace Tests\Feature;

use App\Models\DriverDocument;
use App\Models\DriverProfile;
use App\Models\User;
use App\Services\DriverVerificationService as V;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Driver & vehicle documentation: uploads, security, admin review, and the
 * overall-status calculation. Runs against the real DB inside a transaction
 * (rolled back after each test); files go to a faked private disk.
 */
class DriverDocumentationTest extends TestCase
{
    use DatabaseTransactions;

    private const PDF = "%PDF-1.4\n1 0 obj<< /Type /Catalog >>endobj\ntrailer<< /Root 1 0 R >>\n%%EOF";
    private const JSON = ['Accept' => 'application/json'];

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('driver_documents');
    }

    // ---------------------------------------------------------------- helpers

    private function user(int $type, array $extra = []): User
    {
        return User::create($extra + [
            'name'     => 'Test ' . Str::random(6),
            'email'    => Str::random(10) . '@example.test',
            'phone'    => '07123 456789',
            'password' => 'secret-pass',
            'type'     => $type,
            'status'   => 1,
        ]);
    }

    private function driver(bool $complete = false): User
    {
        $driver = $this->user(2);
        if ($complete) {
            $this->completeDetails($driver);
        }

        return $driver;
    }

    private function admin(): User
    {
        return $this->user(1);
    }

    private function completeDetails(User $driver): void
    {
        $driver->update(['make' => 'Toyota', 'model' => 'Prius']);
        DriverProfile::updateOrCreate(['user_id' => $driver->id], [
            'emergency_contact_name'  => 'Sam Contact',
            'emergency_contact_phone' => '07000 111222',
            'vehicle_year'            => 2021,
            'bank_account_holder'     => $driver->name,
            'bank_account_number'     => '12345678',
            'bank_sort_code'          => '112233',
            'bank_name'               => 'Example Bank',
        ]);
    }

    /** A document row with dummy storage details (status logic doesn't touch the file). */
    private function doc(User $driver, string $type, string $status = 'approved', ?string $expiry = 'auto'): DriverDocument
    {
        $hasExpiry = config("driver_documents.types.{$type}.has_expiry");

        return DriverDocument::create([
            'user_id' => $driver->id, 'type' => $type, 'original_name' => "{$type}.pdf",
            'path' => "x/{$type}.enc", 'mime' => 'application/pdf', 'extension' => 'pdf',
            'size' => 1000, 'checksum' => str_repeat('a', 64), 'status' => $status,
            'uploaded_at' => now(),
            'expiry_date' => $expiry === 'auto' ? ($hasExpiry ? now()->addYear() : null) : $expiry,
        ]);
    }

    private function requiredTypes(): array
    {
        return array_keys(array_filter(config('driver_documents.types'), fn ($t) => $t['required']));
    }

    private function overallStatus(User $driver): string
    {
        return app(V::class)->overall($driver->fresh())['status'];
    }

    private function pdf(string $name = 'doc.pdf'): UploadedFile
    {
        return UploadedFile::fake()->createWithContent($name, self::PDF);
    }

    private function upload(User $as, string $type, UploadedFile $file, array $extra = [], ?User $for = null)
    {
        $url = $for ? route('admin.dv.upload', [$for, $type]) : route('driver.docs.upload', $type);

        return $this->actingAs($as)->post($url, ['document' => $file] + $extra, self::JSON);
    }

    // --------------------------------------------------------- access control

    /** @test */
    public function only_the_right_role_can_reach_each_screen(): void
    {
        $this->get(route('driver.docs.index'))->assertRedirect('/login');
        $this->get(route('admin.dv.index'))->assertRedirect('/login');

        $customer = $this->user(0);
        $this->actingAs($customer)->get(route('driver.docs.index'))->assertRedirect('/login');
        $this->actingAs($customer)->get(route('admin.dv.index'))->assertRedirect('/login');

        $driver = $this->driver();
        $this->actingAs($driver)->get(route('driver.docs.index'))->assertOk();
        $this->actingAs($driver)->get(route('admin.dv.index'))->assertRedirect('/login');
        $this->actingAs($driver)->get(route('admin.dv.show', $driver))->assertRedirect('/login');

        $this->actingAs($this->admin())->get(route('driver.docs.index'))->assertRedirect('/login');
    }

    /** @test */
    public function a_driver_cannot_read_or_delete_another_drivers_document(): void
    {
        $owner = $this->driver();
        $other = $this->driver();
        $this->upload($owner, 'v5c_logbook', $this->pdf())->assertOk();
        $doc = DriverDocument::where('user_id', $owner->id)->firstOrFail();

        $this->actingAs($other)->get(route('driver.docs.file', $doc))->assertNotFound();
        $this->actingAs($other)->deleteJson(route('driver.docs.destroy', $doc))->assertNotFound();
        $this->assertDatabaseHas('driver_documents', ['id' => $doc->id]);

        $this->actingAs($owner)->get(route('driver.docs.file', $doc))->assertOk();
    }

    /** @test */
    public function admin_routes_only_open_real_drivers(): void
    {
        $admin = $this->admin();
        $customer = $this->user(0);

        $this->actingAs($admin)->get(route('admin.dv.show', $customer))->assertNotFound();
        $this->actingAs($admin)->get(route('admin.dv.show', $this->driver()))->assertOk();
    }

    // ----------------------------------------------------------- driver forms

    /** @test */
    public function driver_saves_details_vehicle_and_bank_and_the_bank_numbers_are_encrypted(): void
    {
        $driver = $this->driver();
        $this->actingAs($driver);

        $this->post(route('driver.docs.details'), [
            'name' => 'Jo Driver', 'email' => 'jo@example.test', 'phone' => '07111 222333',
            'emergency_contact_name' => 'Pat', 'emergency_contact_phone' => '07999 888777',
        ])->assertSessionHasNoErrors();

        $this->post(route('driver.docs.vehicle'), ['make' => 'Skoda', 'model' => 'Octavia', 'vehicle_year' => 2020])
            ->assertSessionHasNoErrors();

        $this->post(route('driver.docs.bank'), [
            'bank_account_holder' => 'Jo Driver', 'bank_name' => 'Example Bank',
            'bank_account_number' => '1234 5678', 'bank_sort_code' => '12-34-56',
        ])->assertSessionHasNoErrors();

        $driver->refresh();
        $this->assertSame('Jo Driver', $driver->name);
        $this->assertSame('Skoda', $driver->make);

        $profile = $driver->driverProfile;
        $this->assertSame('12345678', $profile->bank_account_number);   // decrypts back
        $this->assertSame('123456', $profile->bank_sort_code);
        $this->assertSame(2020, $profile->vehicle_year);

        // ...but on disk they are ciphertext, never the plain values.
        $raw = (array) \DB::table('driver_profiles')->where('user_id', $driver->id)->first();
        foreach (['bank_account_holder', 'bank_account_number', 'bank_sort_code', 'bank_name'] as $col) {
            $this->assertNotEmpty($raw[$col]);
            $this->assertStringNotContainsString('12345678', $raw[$col]);
            $this->assertStringNotContainsString('Example Bank', $raw[$col]);
        }
    }

    /** @test */
    public function bank_numbers_are_never_shown_serialised_or_flashed_back(): void
    {
        $driver = $this->driver(true);

        $html = $this->actingAs($driver)->get(route('driver.docs.index'))->assertOk()->getContent();
        $this->assertStringNotContainsString('12345678', $html);
        $this->assertStringNotContainsString('112233', $html);
        $this->assertStringNotContainsString('11-22-33', $html);
        $this->assertStringContainsString('•••• 5678', $html);   // masked account number
        $this->assertStringContainsString('••-••-33', $html);    // masked sort code

        // Never leaks through JSON serialisation of the model either.
        $this->assertArrayNotHasKey('bank_account_number', $driver->driverProfile->toArray());
        $this->assertStringNotContainsString('12345678', $driver->driverProfile->toJson());

        // A failed submission must not echo the typed number/sort code into the session.
        $this->actingAs($driver)->from(route('driver.docs.index'))->post(route('driver.docs.bank'), [
            'bank_account_holder' => 'X', 'bank_name' => 'Y',
            'bank_account_number' => '999', 'bank_sort_code' => '88',
        ])->assertSessionHasErrors(['bank_account_number', 'bank_sort_code'], null, 'bank')
          ->assertSessionMissing('_old_input.bank_account_number')
          ->assertSessionMissing('_old_input.bank_sort_code');
    }

    /** @test */
    public function leaving_bank_number_and_sort_code_blank_keeps_the_saved_ones(): void
    {
        $driver = $this->driver(true);

        $this->actingAs($driver)->post(route('driver.docs.bank'), [
            'bank_account_holder' => 'New Name', 'bank_name' => 'Other Bank',
            'bank_account_number' => '', 'bank_sort_code' => '',
        ])->assertSessionHasNoErrors();

        $profile = $driver->fresh()->driverProfile;
        $this->assertSame('New Name', $profile->bank_account_holder);
        $this->assertSame('12345678', $profile->bank_account_number);
        $this->assertSame('112233', $profile->bank_sort_code);
    }

    /** @test */
    public function required_fields_are_validated(): void
    {
        $driver = $this->driver();
        $this->actingAs($driver);

        $this->post(route('driver.docs.details'), [])
            ->assertSessionHasErrors(['name', 'email', 'phone', 'emergency_contact_name', 'emergency_contact_phone'], null, 'details');
        $this->post(route('driver.docs.vehicle'), [])
            ->assertSessionHasErrors(['make', 'model', 'vehicle_year'], null, 'vehicle');
        $this->post(route('driver.docs.bank'), [])
            ->assertSessionHasErrors(['bank_account_holder', 'bank_name', 'bank_account_number', 'bank_sort_code'], null, 'bank');

        // Email must stay unique across accounts.
        $taken = $this->user(0);
        $this->post(route('driver.docs.details'), [
            'name' => 'A', 'email' => $taken->email, 'phone' => '07111 222333',
            'emergency_contact_name' => 'B', 'emergency_contact_phone' => '07111 222333',
        ])->assertSessionHasErrors(['email'], null, 'details');
    }

    // ---------------------------------------------------------------- uploads

    /** @test */
    public function pdf_jpg_and_png_are_accepted_and_get_thumbnails_only_when_images(): void
    {
        $driver = $this->driver();

        $this->upload($driver, 'v5c_logbook', $this->pdf('v5c.pdf'))->assertOk()->assertJson(['ok' => true]);
        $this->upload($driver, 'driving_licence_front', UploadedFile::fake()->image('front.jpg', 400, 300))->assertOk();
        $this->upload($driver, 'driving_licence_back', UploadedFile::fake()->image('back.png', 400, 300))->assertOk();

        $docs = DriverDocument::where('user_id', $driver->id)->get()->keyBy('type');
        $this->assertSame('application/pdf', $docs['v5c_logbook']->mime);
        $this->assertNull($docs['v5c_logbook']->thumb_path);
        $this->assertNotNull($docs['driving_licence_front']->thumb_path);
        $this->assertNotNull($docs['driving_licence_back']->thumb_path);
        $this->assertSame('uploaded', $docs['v5c_logbook']->status);
    }

    /** @test */
    public function bad_files_are_rejected_by_content_size_and_type(): void
    {
        $driver = $this->driver();

        // Not a PDF, just named like one.
        $this->upload($driver, 'v5c_logbook', UploadedFile::fake()->createWithContent('evil.pdf', '<?php echo 1;'))
            ->assertStatus(422)->assertJson(['ok' => false]);

        // Wrong extension and type.
        $this->upload($driver, 'v5c_logbook', UploadedFile::fake()->createWithContent('run.exe', 'MZ....'))->assertStatus(422);
        $this->upload($driver, 'v5c_logbook', UploadedFile::fake()->createWithContent('notes.txt', 'hello'))->assertStatus(422);

        // An image with a valid extension but PDF-less, non-image bytes.
        $this->upload($driver, 'v5c_logbook', UploadedFile::fake()->createWithContent('fake.png', 'not an image'))->assertStatus(422);

        // Too big (limit is 10 MB).
        $big = UploadedFile::fake()->createWithContent('big.pdf', '%PDF-1.4' . str_repeat('a', 11 * 1024 * 1024));
        $this->upload($driver, 'v5c_logbook', $big)->assertStatus(422);

        // Unknown document type.
        $this->upload($driver, 'passport', $this->pdf())->assertNotFound();

        $this->assertSame(0, DriverDocument::where('user_id', $driver->id)->count());
        $this->assertSame([], Storage::disk('driver_documents')->allFiles());
    }

    /** @test */
    public function stored_files_are_encrypted_and_served_decrypted_with_safe_headers(): void
    {
        $driver = $this->driver();
        $this->upload($driver, 'v5c_logbook', $this->pdf('my v5c.pdf'))->assertOk();
        $doc = DriverDocument::where('user_id', $driver->id)->firstOrFail();

        $onDisk = Storage::disk('driver_documents')->get($doc->path);
        $this->assertStringNotContainsString('%PDF', $onDisk);            // ciphertext
        $this->assertStringEndsWith('.enc', $doc->path);
        $this->assertStringNotContainsString('my v5c', $doc->path);       // random name, not the client's

        $res = $this->actingAs($driver)->get(route('driver.docs.file', $doc));
        $res->assertOk();
        $this->assertSame(self::PDF, $res->getContent());
        $res->assertHeader('Content-Type', 'application/pdf');
        $res->assertHeader('X-Content-Type-Options', 'nosniff');
        $this->assertStringContainsString('no-store', $res->headers->get('Cache-Control'));

        // Storage internals never appear in serialised output.
        $this->assertArrayNotHasKey('path', $doc->toArray());
    }

    /** @test */
    public function the_page_never_links_to_a_public_storage_url(): void
    {
        $driver = $this->driver(true);
        $this->upload($driver, 'v5c_logbook', $this->pdf())->assertOk();

        $html = $this->actingAs($driver)->get(route('driver.docs.index'))->getContent();
        $this->assertStringNotContainsString('/storage/', $html);
        $this->assertStringNotContainsString('.enc', $html);
    }

    /** @test */
    public function replacing_swaps_the_file_resets_review_and_removes_the_old_one(): void
    {
        $driver = $this->driver();
        $this->upload($driver, 'v5c_logbook', $this->pdf('one.pdf'))->assertOk();
        $first = DriverDocument::where('user_id', $driver->id)->firstOrFail();
        $oldPath = $first->path;

        $first->update(['status' => 'rejected', 'rejection_reason' => 'Blurry', 'rejected_at' => now()]);

        $this->upload($driver, 'v5c_logbook', UploadedFile::fake()->image('two.png', 200, 200))->assertOk();

        $doc = DriverDocument::where('user_id', $driver->id)->firstOrFail();
        $this->assertSame($first->id, $doc->id);                    // same slot, not a duplicate
        $this->assertSame('uploaded', $doc->status);
        $this->assertNull($doc->rejection_reason);
        $this->assertSame('image/png', $doc->mime);
        Storage::disk('driver_documents')->assertMissing($oldPath);
        Storage::disk('driver_documents')->assertExists($doc->path);
        $this->assertSame(1, DriverDocument::where('user_id', $driver->id)->count());
        $this->assertDatabaseHas('driver_document_reviews', ['driver_document_id' => $doc->id, 'action' => 'replaced']);
    }

    /** @test */
    public function approved_documents_need_explicit_confirmation_to_replace_and_drivers_cannot_delete_them(): void
    {
        $driver = $this->driver();
        $doc = $this->doc($driver, 'v5c_logbook', 'approved');

        $res = $this->upload($driver, 'v5c_logbook', $this->pdf());
        $res->assertStatus(409)->assertJson(['ok' => false, 'reason' => 'confirm_replace']);
        $this->assertSame('approved', $doc->fresh()->status);

        $this->upload($driver, 'v5c_logbook', $this->pdf(), ['confirm_replace' => 1])->assertOk();
        $this->assertSame('uploaded', $doc->fresh()->status);         // back to review

        $approved = $this->doc($driver, 'bank_statement', 'approved');
        $this->actingAs($driver)->deleteJson(route('driver.docs.destroy', $approved))
            ->assertStatus(403)->assertJson(['reason' => 'approved_locked']);
        $this->assertDatabaseHas('driver_documents', ['id' => $approved->id]);

        // Admins may delete it, and the history line survives the deletion.
        $admin = $this->admin();
        $this->actingAs($admin)->deleteJson(route('admin.dv.destroy', $approved))->assertOk();
        $this->assertDatabaseMissing('driver_documents', ['id' => $approved->id]);
        $this->assertDatabaseHas('driver_document_reviews', ['user_id' => $driver->id, 'document_type' => 'bank_statement', 'action' => 'deleted']);
    }

    /** @test */
    public function an_expired_approved_document_can_be_replaced_without_the_approved_warning(): void
    {
        $driver = $this->driver();
        $this->doc($driver, 'phv_vehicle_licence', 'approved', now()->subDays(3)->toDateString());

        $this->upload($driver, 'phv_vehicle_licence', $this->pdf())->assertOk();
    }

    /** @test */
    public function a_driver_can_delete_their_own_unapproved_document_and_the_file_goes_too(): void
    {
        $driver = $this->driver();
        $this->upload($driver, 'v5c_logbook', $this->pdf())->assertOk();
        $doc = DriverDocument::where('user_id', $driver->id)->firstOrFail();
        $path = $doc->path;

        $this->actingAs($driver)->deleteJson(route('driver.docs.destroy', $doc))->assertOk()->assertJson(['ok' => true]);

        $this->assertDatabaseMissing('driver_documents', ['id' => $doc->id]);
        Storage::disk('driver_documents')->assertMissing($path);
    }

    // ------------------------------------------------------------ admin review

    /** @test */
    public function rejecting_or_requesting_reupload_requires_a_reason_that_the_driver_can_then_see(): void
    {
        $driver = $this->driver(true);
        $admin  = $this->admin();
        $doc    = $this->doc($driver, 'v5c_logbook', 'uploaded');
        $url    = route('admin.dv.review', $doc);

        $this->actingAs($admin)->postJson($url, ['action' => 'reject'])->assertStatus(422)->assertJsonValidationErrors('reason');
        $this->actingAs($admin)->postJson($url, ['action' => 'reupload', 'reason' => '  '])->assertStatus(422);
        $this->assertSame('uploaded', $doc->fresh()->status);

        $this->actingAs($admin)->postJson($url, [
            'action' => 'reject', 'reason' => 'The image is cut off.', 'note' => 'Looks tampered - watch this one.',
        ])->assertOk()->assertJson(['ok' => true]);

        $doc->refresh();
        $this->assertSame('rejected', $doc->status);
        $this->assertSame('The image is cut off.', $doc->rejection_reason);
        $this->assertNotNull($doc->rejected_at);
        $this->assertSame($admin->id, $doc->reviewed_by);

        // The driver sees the reason and a re-upload button - but never the internal note.
        $html = $this->actingAs($driver)->get(route('driver.docs.index'))->getContent();
        $this->assertStringContainsString('The image is cut off.', $html);
        $this->assertStringContainsString('Re-upload', $html);
        $this->assertStringNotContainsString('tampered', $html);
        $this->assertStringNotContainsString('Review &amp; history', $html);

        // The admin sees the history including the internal note.
        $adminHtml = $this->actingAs($admin)->get(route('admin.dv.show', $driver))->getContent();
        $this->assertStringContainsString('tampered', $adminHtml);
        $this->assertDatabaseHas('driver_document_reviews', ['driver_document_id' => $doc->id, 'action' => 'rejected', 'actor_id' => $admin->id]);
    }

    /** @test */
    public function approving_a_document_that_expires_needs_a_current_expiry_date(): void
    {
        $driver = $this->driver();
        $admin  = $this->admin();
        $doc    = $this->doc($driver, 'hire_reward_insurance', 'uploaded', null);
        $url    = route('admin.dv.review', $doc);

        $this->actingAs($admin)->postJson($url, ['action' => 'approve'])->assertStatus(422)->assertJsonValidationErrors('expiry_date');
        $this->actingAs($admin)->postJson($url, ['action' => 'approve', 'expiry_date' => now()->subDay()->toDateString()])
            ->assertStatus(422)->assertJsonValidationErrors('expiry_date');
        $this->actingAs($admin)->postJson($url, ['action' => 'approve', 'issue_date' => '2027-01-01', 'expiry_date' => '2026-12-01'])
            ->assertStatus(422);

        $future = now()->addMonths(6)->toDateString();
        $this->actingAs($admin)->postJson($url, ['action' => 'approve', 'expiry_date' => $future, 'issue_date' => now()->subMonth()->toDateString()])
            ->assertOk();

        $doc->refresh();
        $this->assertSame('approved', $doc->status);
        $this->assertSame($future, $doc->expiry_date->toDateString());
    }

    /** @test */
    public function document_types_without_expiry_dates_do_not_ask_for_one(): void
    {
        $driver = $this->driver();
        $doc = $this->doc($driver, 'v5c_logbook', 'uploaded');

        $this->actingAs($this->admin())->postJson(route('admin.dv.review', $doc), ['action' => 'approve', 'expiry_date' => '2030-01-01'])->assertOk();

        $this->assertSame('approved', $doc->fresh()->status);
        $this->assertNull($doc->fresh()->expiry_date);               // ignored - this type has no expiry
    }

    /** @test */
    public function only_admins_can_review_and_notes_and_dates_are_recorded_in_history(): void
    {
        $driver = $this->driver();
        $doc = $this->doc($driver, 'phv_vehicle_licence', 'under_review', null);
        $url = route('admin.dv.review', $doc);

        // A driver posting to the admin route is bounced by the role middleware.
        $this->actingAs($driver)->postJson($url, ['action' => 'approve', 'expiry_date' => '2030-01-01'])->assertRedirect('/login');
        $this->assertSame('under_review', $doc->fresh()->status);

        $admin = $this->admin();
        $this->actingAs($admin)->postJson($url, ['action' => 'note'])->assertStatus(422);
        $this->actingAs($admin)->postJson($url, ['action' => 'note', 'note' => 'Called the council.'])->assertOk();
        $this->actingAs($admin)->postJson($url, ['action' => 'dates', 'issue_date' => '2026-01-01', 'expiry_date' => '2027-01-01'])->assertOk();

        $this->assertSame('under_review', $doc->fresh()->status);      // neither changes the status
        $this->assertSame(['dates_updated', 'note'], $doc->reviews()->pluck('action')->sort()->values()->all());
    }

    /** @test */
    public function begin_review_moves_new_uploads_to_under_review(): void
    {
        $driver = $this->driver();
        $a = $this->doc($driver, 'v5c_logbook', 'uploaded');
        $b = $this->doc($driver, 'bank_statement', 'approved');

        $this->actingAs($this->admin())->post(route('admin.dv.start-review', $driver))->assertSessionHas('dd_success');

        $this->assertSame('under_review', $a->fresh()->status);
        $this->assertSame('approved', $b->fresh()->status);
    }

    /** @test */
    public function admin_can_upload_and_enter_details_on_behalf_of_a_driver(): void
    {
        $driver = $this->driver();
        $admin  = $this->admin();

        $this->upload($admin, 'v5c_logbook', $this->pdf(), [], $driver)->assertOk();
        $doc = DriverDocument::where('user_id', $driver->id)->firstOrFail();
        $this->assertSame($admin->id, $doc->uploaded_by);

        $this->actingAs($admin)->post(route('admin.dv.vehicle', $driver), ['make' => 'Ford', 'model' => 'Focus', 'vehicle_year' => 2019])
            ->assertSessionHasNoErrors();
        $this->assertSame('Ford', $driver->fresh()->make);

        $this->actingAs($admin)->get(route('admin.dv.file', $doc))->assertOk();
    }

    /** @test */
    public function admin_list_and_review_screen_render_with_driver_details(): void
    {
        $driver = $this->driver(true);
        $this->doc($driver, 'v5c_logbook', 'uploaded');
        $admin = $this->admin();

        $this->actingAs($admin)->get(route('admin.dv.index'))
            ->assertOk()->assertSee($driver->name)->assertSee('Driver Verification');

        $this->actingAs($admin)->get(route('admin.dv.index', ['status' => V::INCOMPLETE, 'q' => $driver->email]))
            ->assertOk()->assertSee($driver->email);

        $this->actingAs($admin)->get(route('admin.dv.show', $driver))
            ->assertOk()
            ->assertSee($driver->name)->assertSee($driver->email)->assertSee($driver->phone)
            ->assertSee('Overall Status')->assertSee('Begin review')
            ->assertSee('PHV Vehicle Licence')->assertSee('V5C Vehicle Logbook')
            ->assertSee('Review &amp; history', false);
    }

    // ------------------------------------------------------------ overall status

    /** @test */
    public function status_is_incomplete_until_everything_required_is_in(): void
    {
        $driver = $this->driver();
        $this->assertSame(V::INCOMPLETE, $this->overallStatus($driver));

        $this->completeDetails($driver);
        $this->doc($driver, 'v5c_logbook', 'uploaded');
        $this->assertSame(V::INCOMPLETE, $this->overallStatus($driver));
    }

    /** @test */
    public function the_spec_example_is_requires_action(): void
    {
        $driver = $this->driver(true);
        foreach ($this->requiredTypes() as $type) {
            if ($type !== 'vehicle_inspection') {
                $this->doc($driver, $type, 'approved');
            }
        }

        $overall = app(V::class)->overall($driver->fresh());
        $this->assertSame(V::REQUIRES_ACTION, $overall['status']);

        $items = collect($overall['items'])->keyBy('key');
        $this->assertSame('action', $items['vehicle_inspection']['state']);
        $this->assertSame('Required', $items['vehicle_inspection']['note']);
        $this->assertSame('ok', $items['phv_vehicle_licence']['state']);
    }

    /** @test */
    public function status_moves_through_submitted_under_review_partial_and_verified(): void
    {
        $driver = $this->driver(true);
        $types  = $this->requiredTypes();

        foreach ($types as $type) {
            $this->doc($driver, $type, 'uploaded');
        }
        $this->assertSame(V::DOCUMENTS_SUBMITTED, $this->overallStatus($driver));

        DriverDocument::where('user_id', $driver->id)->update(['status' => 'under_review']);
        $this->assertSame(V::UNDER_REVIEW, $this->overallStatus($driver));

        DriverDocument::where('user_id', $driver->id)->where('type', $types[0])->update(['status' => 'approved']);
        $this->assertSame(V::PARTIALLY_APPROVED, $this->overallStatus($driver));

        DriverDocument::where('user_id', $driver->id)->update(['status' => 'approved']);
        $this->assertSame(V::VERIFIED, $this->overallStatus($driver));
    }

    /** @test */
    public function a_rejected_or_expired_required_document_means_requires_action(): void
    {
        $driver = $this->driver(true);
        foreach ($this->requiredTypes() as $type) {
            $this->doc($driver, $type, 'approved');
        }
        $this->assertSame(V::VERIFIED, $this->overallStatus($driver));

        DriverDocument::where('user_id', $driver->id)->where('type', 'v5c_logbook')->update(['status' => 'rejected']);
        $this->assertSame(V::REQUIRES_ACTION, $this->overallStatus($driver));

        DriverDocument::where('user_id', $driver->id)->where('type', 'v5c_logbook')->update(['status' => 'approved']);
        DriverDocument::where('user_id', $driver->id)->where('type', 'phv_vehicle_licence')->update(['expiry_date' => now()->subDay()]);
        $this->assertSame(V::REQUIRES_ACTION, $this->overallStatus($driver));
    }

    /** @test */
    public function optional_documents_never_block_verification(): void
    {
        $driver = $this->driver(true);
        foreach ($this->requiredTypes() as $type) {
            $this->doc($driver, $type, 'approved');
        }
        $this->doc($driver, 'driving_licence_back', 'rejected');       // optional, and rejected

        $this->assertSame(V::VERIFIED, $this->overallStatus($driver));
    }

    // ------------------------------------------------------------ expiry rules

    /** @test */
    public function expiry_warnings_follow_the_configured_windows(): void
    {
        $driver = $this->driver();
        $cases = [
            [-3, 'expired', 'Expired 3 days ago'],
            [0, 'soon', 'Expires today'],
            [5, 'soon', 'Expires soon — in 5 days'],
            [30, 'warning', 'Expires in 30 days'],
            [120, 'valid', null],
        ];

        foreach ($cases as [$days, $state, $label]) {
            $doc = $this->doc($driver, 'phv_vehicle_licence', 'approved', now()->addDays($days)->toDateString());
            $info = $doc->expiryInfo();
            $this->assertSame($state, $info['state'], "{$days} days");
            if ($label) {
                $this->assertSame($label, $info['label']);
            }
            $this->assertSame($days < 0 ? 'expired' : 'approved', $doc->effectiveStatus());
            $doc->delete();
        }

        $this->assertNull($this->doc($driver, 'v5c_logbook', 'approved')->expiryInfo());   // no expiry configured
    }

    /** @test */
    public function the_driver_page_shows_expiry_warnings_and_status_labels(): void
    {
        $driver = $this->driver(true);
        $this->doc($driver, 'phv_vehicle_licence', 'approved', now()->addDays(20)->toDateString());
        $this->doc($driver, 'hire_reward_insurance', 'approved', now()->subDays(2)->toDateString());

        $this->actingAs($driver)->get(route('driver.docs.index'))
            ->assertOk()
            ->assertSee('Expires in 20 days')
            ->assertSee('Expired 2 days ago')
            ->assertSee('Not Uploaded')
            ->assertSee('Replace Document')
            ->assertSee('Drag &amp; drop your file here', false)
            ->assertSee('Browse Files');
    }

    // ------------------------------------------------------------- misc rules

    /** @test */
    public function the_bank_holder_name_check_ignores_order_and_middle_names(): void
    {
        $p = new DriverProfile(['bank_account_holder' => 'Mr Sam J Smith']);
        $this->assertTrue($p->holderMatches('Sam Smith'));
        $this->assertTrue($p->holderMatches('Smith Sam'));
        $this->assertFalse($p->holderMatches('Alex Jones'));
        $this->assertNull((new DriverProfile())->holderMatches('Sam Smith'));
    }

    /** @test */
    public function every_configured_document_type_is_well_formed(): void
    {
        $groups = config('driver_documents.groups');

        foreach (config('driver_documents.types') as $key => $def) {
            $this->assertArrayHasKey($def['group'], $groups, $key);
            foreach (['label', 'short', 'description'] as $field) {
                $this->assertNotEmpty($def[$field], "{$key}.{$field}");
            }
            $this->assertIsBool($def['required']);
            $this->assertIsBool($def['has_expiry']);
            $this->assertIsBool($def['has_issue_date']);
        }
    }
}
