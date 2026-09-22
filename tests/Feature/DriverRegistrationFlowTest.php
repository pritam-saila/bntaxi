<?php

namespace Tests\Feature;

use App\Models\Cars;
use App\Models\DriverDocument;
use App\Models\DriverProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Registration -> documents -> admin verification -> activation.
 * Real DB inside a transaction; files go to faked disks.
 */
class DriverRegistrationFlowTest extends TestCase
{
    use DatabaseTransactions;

    private const PDF = "%PDF-1.4\n1 0 obj<< /Type /Catalog >>endobj\ntrailer<< /Root 1 0 R >>\n%%EOF";

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('driver_documents');
        Storage::fake('public');

        if (!Cars::query()->exists()) {
            $this->markTestSkipped('The cars table is empty - the registration form needs a car type.');
        }
    }

    // ---------------------------------------------------------------- helpers

    private function registration(array $override = []): array
    {
        return $override + [
            'first_name'       => 'Riley',
            'last_name'        => 'Applicant',
            'email'            => Str::random(8) . '@example.test',
            'password'         => 'a-long-password',
            'phone'            => '07123 456789',
            'address'          => '1 High Street, Leeds',
            'postcode'         => 'LS1 4DY',
            'vehicleregnumber' => 'AB12 CDE',
            'make'             => 'Toyota',
            'model'            => 'Prius',
            'cartype'          => Cars::query()->value('id'),
            'checkbox'         => 'on',
        ];
    }

    private function applicant(): User
    {
        $u = User::create(['name' => 'App ' . Str::random(4), 'email' => Str::random(8) . '@example.test', 'phone' => '07123 456789',
            'password' => 'secret-pass', 'type' => 2, 'status' => 0]);
        DriverProfile::create(['user_id' => $u->id, 'application_status' => 'pending']);

        return $u;
    }

    private function admin(): User
    {
        return User::create(['name' => 'Admin', 'email' => Str::random(8) . '@example.test', 'password' => 'secret-pass', 'type' => 1, 'status' => 1]);
    }

    private function activeDriver(): User
    {
        return User::create(['name' => 'Active', 'email' => Str::random(8) . '@example.test', 'phone' => '07123 456789',
            'password' => 'secret-pass', 'type' => 2, 'status' => 1]);
    }

    private function completeAndApproveEverything(User $driver): void
    {
        $driver->update(['make' => 'Toyota', 'model' => 'Prius']);
        DriverProfile::updateOrCreate(['user_id' => $driver->id], [
            'emergency_contact_name' => 'Pat', 'emergency_contact_phone' => '07000 111222', 'vehicle_year' => 2021,
            'bank_account_holder' => $driver->name, 'bank_account_number' => '12345678', 'bank_sort_code' => '112233', 'bank_name' => 'Bank',
        ]);
        foreach (config('driver_documents.types') as $type => $def) {
            if ($def['required']) {
                DriverDocument::create([
                    'user_id' => $driver->id, 'type' => $type, 'original_name' => 'x.pdf', 'path' => "x/{$type}.enc", 'mime' => 'application/pdf',
                    'extension' => 'pdf', 'size' => 10, 'checksum' => str_repeat('a', 64), 'status' => 'approved', 'uploaded_at' => now(),
                    'expiry_date' => $def['has_expiry'] ? now()->addYear() : null,
                ]);
            }
        }
    }

    // ------------------------------------------------------------ registration

    /** @test */
    public function registering_creates_a_pending_inactive_application_and_lands_on_the_documents_step(): void
    {
        $data = $this->registration();

        $this->post('/post-driver-register', $data)->assertRedirect(route('driver.docs.index'));

        $driver = User::where('email', $data['email'])->firstOrFail();
        $this->assertSame(2, (int) $driver->getRawOriginal('type'));
        $this->assertSame(0, (int) $driver->status);                       // inactive until an admin approves
        $this->assertNotSame($data['password'], $driver->password);         // hashed
        $this->assertSame('pending', $driver->driverProfile->application_status);
        $this->assertSame('Toyota', $driver->make);
        $this->assertSame('Riley', $driver->first_name);
        $this->assertSame('Applicant', $driver->last_name);
        $this->assertSame('Riley Applicant', $driver->name);          // combined, so bookings/emails/admin lists keep working
        $this->assertSame('LS1 4DY', $driver->postcode);
        $this->assertAuthenticatedAs($driver);

        $this->get(route('driver.docs.index'))
            ->assertOk()
            ->assertSee('Complete your driver application')
            ->assertSee('Details &amp; documents', false)
            ->assertSee('Your account has been created')
            ->assertSee('Drag &amp; drop your file here', false);
    }

    /** @test */
    public function the_registration_form_offers_the_new_document_step_and_no_longer_stores_files_publicly(): void
    {
        $html = $this->get('/driver-register')->assertOk()->getContent();

        $this->assertDoesNotMatchRegularExpression('/<input[^>]*type="file"/i', $html);
        $this->assertStringNotContainsString('enctype="multipart', $html);
        $this->assertStringContainsString('Step 2: upload your documents', $html);
        $this->assertStringContainsString('V5C Vehicle Logbook', $html);
        $this->assertStringContainsString('Hire &amp; Reward Insurance Certificate', $html);

        // Company Name / VAT Number / Company Reg Number are gone from this form.
        $this->assertStringNotContainsString('name="company_name"', $html);
        $this->assertStringNotContainsString('name="vatnumber"', $html);
        $this->assertStringNotContainsString('name="companyregnumber"', $html);
        // First/Last name and Post Code replace the single Name field.
        $this->assertStringContainsString('name="first_name"', $html);
        $this->assertStringContainsString('name="last_name"', $html);
        $this->assertStringContainsString('name="postcode"', $html);
        $this->assertStringNotContainsString('name="name"', $html);

        // Even a hand-crafted upload to the old field names is ignored.
        $this->post('/post-driver-register', $this->registration() + [
            'hireandrewardinsurance' => UploadedFile::fake()->createWithContent('i.pdf', self::PDF),
        ])->assertRedirect();
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    /** @test */
    public function registration_is_validated_and_creates_nothing_when_it_fails(): void
    {
        $existing = $this->activeDriver();
        $before = User::count();

        $this->post('/post-driver-register', $this->registration(['checkbox' => null]))->assertSessionHasErrors('checkbox');
        $this->post('/post-driver-register', $this->registration(['email' => $existing->email]))->assertSessionHasErrors('email');
        $this->post('/post-driver-register', $this->registration(['password' => 'short']))->assertSessionHasErrors('password');
        $this->post('/post-driver-register', $this->registration(['cartype' => 999999]))->assertSessionHasErrors('cartype');
        $this->post('/post-driver-register', $this->registration(['phone' => 'call me']))->assertSessionHasErrors('phone');
        $this->post('/post-driver-register', $this->registration(['postcode' => 'not a postcode']))->assertSessionHasErrors('postcode');
        $this->post('/post-driver-register', [])->assertSessionHasErrors(['first_name', 'last_name', 'email', 'password', 'phone', 'address', 'postcode', 'vehicleregnumber', 'make', 'model', 'cartype']);

        $this->assertSame($before, User::count());
        $this->assertGuest();
    }

    /** @test */
    public function the_form_shows_errors_and_keeps_what_was_typed(): void
    {
        $this->from('/driver-register')->post('/post-driver-register', $this->registration(['first_name' => 'Kept Name', 'checkbox' => null]));

        $html = $this->get('/driver-register')->getContent();
        $this->assertStringContainsString('Please fix the following', $html);
        $this->assertStringContainsString('Please agree to the terms', $html);
        $this->assertStringContainsString('value="Kept Name"', $html);
        $this->assertStringNotContainsString('a-long-password', $html);       // password is never echoed
    }

    /** @test */
    public function the_same_email_can_register_as_a_customer_and_as_a_driver(): void
    {
        $email = Str::random(8) . '@example.test';

        $this->post('/postregister', ['name' => 'Riley Customer', 'email' => $email, 'password' => 'a-long-password', 'phone' => '07123 456789'])
            ->assertSessionHasNoErrors();

        $this->post('/post-driver-register', $this->registration(['email' => $email]))->assertSessionHasNoErrors();

        $this->assertSame(2, User::where('email', $email)->count());
        $this->assertNotNull(User::where('email', $email)->where('type', 0)->first());
        $this->assertNotNull(User::where('email', $email)->where('type', 2)->first());
    }

    /** @test */
    public function the_same_email_cannot_register_twice_as_a_driver(): void
    {
        $existing = $this->activeDriver();

        $this->post('/post-driver-register', $this->registration(['email' => $existing->email]))
            ->assertSessionHasErrors('email');
        $this->assertSame(1, User::where('email', $existing->email)->count());
    }

    /** @test */
    public function registration_cannot_smuggle_in_an_admin_type_or_an_active_status(): void
    {
        $data = $this->registration(['type' => 1, 'status' => 1, 'email_verified_at' => now()]);

        $this->post('/post-driver-register', $data);

        $driver = User::where('email', $data['email'])->firstOrFail();
        $this->assertSame(2, (int) $driver->getRawOriginal('type'));
        $this->assertSame(0, (int) $driver->status);
        $this->assertNull($driver->email_verified_at);
    }

    // ------------------------------------------------------- applicant sandbox

    /** @test */
    public function an_applicant_can_fill_in_details_and_upload_documents(): void
    {
        $driver = $this->applicant();

        $this->actingAs($driver)->post(route('driver.docs.upload', 'v5c_logbook'),
            ['document' => UploadedFile::fake()->createWithContent('v5c.pdf', self::PDF)], ['Accept' => 'application/json'])
            ->assertOk()->assertJson(['ok' => true]);

        $this->actingAs($driver)->post(route('driver.docs.vehicle'), ['make' => 'Ford', 'model' => 'Focus', 'vehicle_year' => 2020])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('driver_documents', ['user_id' => $driver->id, 'type' => 'v5c_logbook', 'status' => 'uploaded']);
        $this->assertSame('Ford', $driver->fresh()->make);
    }

    /** @test */
    public function an_applicant_is_kept_out_of_everything_except_their_documents(): void
    {
        $driver = $this->applicant();
        $this->actingAs($driver);

        foreach (['/manager/home', '/driver-booking', '/driver-accepted-booking', '/driver-account', '/driver-change-password'] as $url) {
            $this->get($url)->assertRedirect(route('driver.docs.index'));
        }

        // The old profile form let a driver set their own status - an applicant must not reach it.
        $this->post('/driver-update', ['status' => 1, 'type' => 1])->assertRedirect(route('driver.docs.index'));
        $fresh = $driver->fresh();
        $this->assertSame(0, (int) $fresh->status);
        $this->assertSame(2, (int) $fresh->getRawOriginal('type'));

        $this->get(route('driver.docs.index'))->assertOk()
            ->assertSee('My Documents')
            ->assertDontSee('Accepted Booking')
            ->assertDontSee('Change Password');
    }

    // ------------------------------------------------------------------ login

    /** @test */
    public function login_lets_a_pending_applicant_in_to_their_documents_only(): void
    {
        $driver = $this->applicant();

        $this->post('/login', ['email' => $driver->email, 'password' => 'secret-pass', 'type' => 2])
            ->assertRedirect(route('driver.docs.index'));
        $this->assertAuthenticatedAs($driver);
    }

    /** @test */
    public function login_still_refuses_inactive_declined_and_legacy_drivers_with_the_generic_message(): void
    {
        $legacy = User::create(['name' => 'Old', 'email' => Str::random(8) . '@example.test', 'password' => 'secret-pass', 'type' => 2, 'status' => 0]);
        $declined = $this->applicant();
        $declined->driverProfile->update(['application_status' => 'declined']);
        $approvedThenDeactivated = $this->applicant();
        $approvedThenDeactivated->driverProfile->update(['application_status' => 'approved']);

        foreach ([$legacy, $declined, $approvedThenDeactivated] as $user) {
            $this->post('/login', ['email' => $user->email, 'password' => 'secret-pass', 'type' => 2])
                ->assertSessionHas('error', 'Email-Address And Password Are Wrong.');
            $this->assertGuest();
        }
    }

    /** @test */
    public function login_still_sends_active_drivers_to_the_working_area_and_rejects_bad_passwords(): void
    {
        $active = $this->activeDriver();

        $this->post('/login', ['email' => $active->email, 'password' => 'wrong', 'type' => 2])->assertSessionHas('error');
        $this->assertGuest();

        $this->post('/login', ['email' => $active->email, 'password' => 'secret-pass', 'type' => 2])->assertRedirect(route('manager.home'));
        $this->get('/manager/home')->assertRedirect('/driver-booking');
    }

    // ------------------------------------------------------ admin verification

    /** @test */
    public function admin_needs_confirmation_to_activate_an_unverified_applicant_and_activation_unlocks_the_account(): void
    {
        $driver = $this->applicant();
        $admin = $this->admin();
        $url = route('admin.dv.application', $driver);

        $this->actingAs($admin)->post($url, ['action' => 'approve'])->assertSessionHas('error');
        $this->assertSame(0, (int) $driver->fresh()->status);

        $this->actingAs($admin)->post($url, ['action' => 'approve', 'force' => 1])->assertSessionHas('dd_success');

        $driver->refresh();
        $this->assertSame(1, (int) $driver->status);
        $this->assertSame('approved', $driver->driverProfile->application_status);
        $this->assertSame($admin->id, (int) $driver->driverProfile->application_decided_by);

        $this->actingAs($driver)->get('/manager/home')->assertRedirect('/driver-booking');
        $this->actingAs($driver)->get('/driver-booking')->assertOk();
    }

    /** @test */
    public function a_fully_verified_applicant_is_activated_without_the_override(): void
    {
        $driver = $this->applicant();
        $this->completeAndApproveEverything($driver);

        $this->actingAs($this->admin())->post(route('admin.dv.application', $driver), ['action' => 'approve'])->assertSessionHas('dd_success');

        $this->assertSame(1, (int) $driver->fresh()->status);
    }

    /** @test */
    public function declining_blocks_the_applicant_and_only_pending_applications_can_be_declined(): void
    {
        $driver = $this->applicant();
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.dv.application', $driver), ['action' => 'decline'])->assertSessionHas('dd_success');
        $this->assertSame('declined', $driver->fresh()->driverProfile->application_status);

        auth()->logout();
        $this->post('/login', ['email' => $driver->email, 'password' => 'secret-pass', 'type' => 2])->assertSessionHas('error');
        $this->assertGuest();

        $this->actingAs($admin)->post(route('admin.dv.application', $driver), ['action' => 'decline'])->assertSessionHas('error');
        $this->actingAs($admin)->post(route('admin.dv.application', $this->activeDriver()), ['action' => 'decline'])->assertSessionHas('error');
    }

    /** @test */
    public function deactivating_kicks_an_active_driver_out_of_the_working_area(): void
    {
        $driver = $this->activeDriver();

        $this->actingAs($this->admin())->post(route('admin.dv.application', $driver), ['action' => 'deactivate'])->assertSessionHas('dd_success');
        $this->assertSame(0, (int) $driver->fresh()->status);

        $this->actingAs($driver->fresh())->get('/driver-booking')->assertRedirect('/driver-login');
        $this->assertGuest();
    }

    /** @test */
    public function only_admins_can_make_the_decision(): void
    {
        $driver = $this->applicant();

        $this->actingAs($driver)->post(route('admin.dv.application', $driver), ['action' => 'approve', 'force' => 1])->assertRedirect('/login');
        $this->assertSame(0, (int) $driver->fresh()->status);

        $this->actingAs($this->admin())->post(route('admin.dv.application', $driver), ['action' => 'nonsense'])->assertSessionHasErrors('action');
    }

    /** @test */
    public function the_admin_screens_show_the_application_and_its_controls(): void
    {
        $driver = $this->applicant();
        $admin = $this->admin();

        $this->actingAs($admin)->get(route('admin.dv.index'))
            ->assertOk()->assertSee($driver->email)->assertSee('Application pending')->assertSee('New applications');

        $this->actingAs($admin)->get(route('admin.dv.index', ['application' => 'pending']))->assertOk()->assertSee($driver->email);
        $this->actingAs($admin)->get(route('admin.dv.index', ['application' => 'pending', 'q' => 'zzz-no-such-driver']))->assertDontSee($driver->email);

        $this->actingAs($admin)->get(route('admin.dv.show', $driver))
            ->assertOk()->assertSee('Approve &amp; activate account', false)->assertSee('Decline application')->assertSee('Pending');

        $this->actingAs($admin)->get(route('admin.dv.show', $this->activeDriver()))
            ->assertOk()->assertSee('Deactivate account')->assertDontSee('Approve &amp; activate account', false);
    }

    /** @test */
    public function activating_through_the_old_driver_edit_page_settles_the_application_too(): void
    {
        $driver = $this->applicant();

        $this->actingAs($this->admin())->patch(route('admdriver.update', $driver->id), [
            'name' => $driver->name, 'email' => $driver->email, 'phone' => $driver->phone, 'status' => 1,
        ])->assertRedirect('/admdriver');

        $this->assertSame(1, (int) $driver->fresh()->status);
        $this->assertSame('approved', $driver->fresh()->driverProfile->application_status);
    }
}
