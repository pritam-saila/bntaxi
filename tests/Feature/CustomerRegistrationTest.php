<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Customer ("normal user") registration - /postregister.
 */
class CustomerRegistrationTest extends TestCase
{
    use DatabaseTransactions;

    private function registration(array $override = []): array
    {
        return $override + [
            'name'     => 'Riley Customer',
            'email'    => Str::random(8) . '@example.test',
            'password' => 'a-long-password',
            'phone'    => '07123 456789',
        ];
    }

    /** @test */
    public function registering_creates_an_active_customer_account(): void
    {
        $data = $this->registration();

        $this->post('/postregister', $data)->assertRedirect('/user-login')->assertSessionHas('success');

        $user = User::where('email', $data['email'])->firstOrFail();
        $this->assertSame(0, (int) $user->getRawOriginal('type'));
        $this->assertSame(1, (int) $user->status);
        $this->assertTrue(Hash::check('a-long-password', $user->password));
    }

    /** @test */
    public function it_is_validated_and_cannot_smuggle_in_an_admin_type_or_active_status_bypass(): void
    {
        $before = User::count();

        $this->post('/postregister', [])->assertSessionHasErrors(['name', 'email', 'password', 'phone']);
        $this->post('/postregister', $this->registration(['password' => 'short']))->assertSessionHasErrors('password');
        $this->assertSame($before, User::count());

        // type/status are not user-controllable, even if posted.
        $data = $this->registration(['type' => 1, 'status' => 0]);
        $this->post('/postregister', $data);
        $user = User::where('email', $data['email'])->firstOrFail();
        $this->assertSame(0, (int) $user->getRawOriginal('type'));
        $this->assertSame(1, (int) $user->status);
    }

    /** @test */
    public function the_same_email_cannot_register_twice_as_a_customer_but_can_also_be_a_driver(): void
    {
        $existing = User::create(['name' => 'Existing', 'email' => Str::random(8) . '@example.test', 'password' => 'secret-pass', 'type' => 0, 'status' => 1]);

        $this->post('/postregister', $this->registration(['email' => $existing->email]))->assertSessionHasErrors('email');
        $this->assertSame(1, User::where('email', $existing->email)->count());

        // A driver account with the same email is a different role, not a clash.
        $driverEmail = Str::random(8) . '@example.test';
        User::create(['name' => 'Driver', 'email' => $driverEmail, 'password' => 'secret-pass', 'type' => 2, 'status' => 1]);
        $this->post('/postregister', $this->registration(['email' => $driverEmail]))->assertSessionHasNoErrors();
        $this->assertSame(1, User::where('email', $driverEmail)->where('type', 0)->count());
    }
}
