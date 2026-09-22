<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

/** The driver's My Account and Change Password pages. */
class DriverAccountPagesTest extends TestCase
{
    use DatabaseTransactions;

    private function driver(array $extra = []): User
    {
        return User::create($extra + [
            'name' => 'Sam Driver', 'email' => Str::random(8) . '@example.test', 'phone' => '07123 456789',
            'password' => 'old-password', 'type' => 2, 'status' => 1, 'address' => '1 High St',
            'vehicleregnumber' => 'AB12 CDE', 'make' => 'Toyota', 'model' => 'Prius',
        ]);
    }

    private function valid(array $override = []): array
    {
        return $override + [
            'name' => 'Sam Updated', 'email' => Str::random(8) . '@example.test', 'phone' => '07999 111222',
            'company_name' => 'SW Cars', 'address' => '2 Low Rd', 'vatnumber' => 'GB123', 'companyregnumber' => '999',
            'vehicleregnumber' => 'ZZ99 ZZZ', 'make' => 'Skoda', 'model' => 'Octavia',
        ];
    }

    /** @test */
    public function the_account_page_is_a_structured_page_with_documents_status_and_no_status_dropdown(): void
    {
        $driver = $this->driver();

        $html = $this->actingAs($driver)->get(route('driveraccount'))->assertOk()->getContent();

        foreach (['My Account', 'Personal details', 'Business details', 'Vehicle', 'Documents &amp; verification', 'Manage documents', 'Save changes'] as $text) {
            $this->assertStringContainsString($text, $html);
        }
        $this->assertStringContainsString(route('driver.docs.index'), $html);

        // The old free-text insurance boxes and the self-service status dropdown are gone.
        $this->assertStringNotContainsString('name="status"', $html);
        $this->assertStringNotContainsString('hireandrewardinsurance', $html);
        $this->assertStringNotContainsString('insuance', $html);
    }

    /** @test */
    public function saving_updates_the_listed_fields(): void
    {
        $driver = $this->driver();
        $data = $this->valid();

        $this->actingAs($driver)->post('/driver-update', $data)->assertRedirect(route('driveraccount'))->assertSessionHas('success');

        $driver->refresh();
        $this->assertSame('Sam Updated', $driver->name);
        $this->assertSame($data['email'], $driver->email);
        $this->assertSame('Skoda', $driver->make);
        $this->assertSame('SW Cars', $driver->company_name);
    }

    /** @test */
    public function a_driver_cannot_promote_or_activate_or_repassword_themselves_through_the_form(): void
    {
        $driver = $this->driver(['status' => 1]);
        $hash = $driver->password;

        $this->actingAs($driver)->post('/driver-update', $this->valid([
            'type' => 1, 'status' => 0, 'password' => 'hacked-pass', 'email_verified_at' => now(),
        ]))->assertSessionHas('success');

        $fresh = $driver->fresh();
        $this->assertSame(2, (int) $fresh->getRawOriginal('type'));
        $this->assertSame(1, (int) $fresh->status);
        $this->assertSame($hash, $fresh->password);
        $this->assertNull($fresh->email_verified_at);
    }

    /** @test */
    public function saving_validates_and_keeps_emails_unique(): void
    {
        $driver = $this->driver();
        $other = $this->driver();

        $this->actingAs($driver)->post('/driver-update', $this->valid(['email' => $other->email]))->assertSessionHasErrors('email');
        $this->actingAs($driver)->post('/driver-update', $this->valid(['phone' => 'call me']))->assertSessionHasErrors('phone');
        $this->actingAs($driver)->post('/driver-update', [])->assertSessionHasErrors(['name', 'email', 'phone', 'address', 'vehicleregnumber', 'make', 'model']);

        // Keeping your own email is fine.
        $this->actingAs($driver)->post('/driver-update', $this->valid(['email' => $driver->email]))->assertSessionHasNoErrors();
        $this->assertSame('Sam Updated', $driver->fresh()->name);
    }

    /** @test */
    public function the_change_password_page_uses_real_password_fields_and_posts_to_the_right_place(): void
    {
        $html = $this->actingAs($this->driver())->get(route('driverchangepass'))->assertOk()->getContent();

        $this->assertStringContainsString('action="' . route('driverchangepassword.update') . '"', $html);
        foreach (['current_password', 'password', 'password_confirmation'] as $field) {
            $this->assertMatchesRegularExpression('/<input[^>]*type="password"[^>]*name="' . $field . '"/', $html, $field);
        }
    }

    /** @test */
    public function changing_the_password_needs_the_current_one_and_a_matching_new_one(): void
    {
        $driver = $this->driver();
        $this->actingAs($driver);

        $this->post(route('driverchangepassword.update'), ['current_password' => 'wrong', 'password' => 'brand-new-pass', 'password_confirmation' => 'brand-new-pass'])
            ->assertSessionHasErrors('current_password');
        $this->post(route('driverchangepassword.update'), ['current_password' => 'old-password', 'password' => 'short', 'password_confirmation' => 'short'])
            ->assertSessionHasErrors('password');
        $this->post(route('driverchangepassword.update'), ['current_password' => 'old-password', 'password' => 'brand-new-pass', 'password_confirmation' => 'different'])
            ->assertSessionHasErrors('password');
        $this->assertTrue(Hash::check('old-password', $driver->fresh()->password));

        $this->post(route('driverchangepassword.update'), ['current_password' => 'old-password', 'password' => 'brand-new-pass', 'password_confirmation' => 'brand-new-pass'])
            ->assertRedirect(route('driverchangepass'))->assertSessionHas('success');

        $this->assertTrue(Hash::check('brand-new-pass', $driver->fresh()->password));
    }

    /** @test */
    public function these_pages_stay_closed_to_pending_applicants(): void
    {
        $applicant = $this->driver(['status' => 0]);
        \App\Models\DriverProfile::create(['user_id' => $applicant->id, 'application_status' => 'pending']);

        $this->actingAs($applicant)->get(route('driveraccount'))->assertRedirect(route('driver.docs.index'));
        $this->actingAs($applicant)->post(route('driverchangepassword.update'), [])->assertRedirect(route('driver.docs.index'));
    }
}
