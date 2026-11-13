<?php

namespace Tests\Feature;

use App\Mail\AdminBookingNotificationMail;
use App\Mail\BookingPaymentIncompleteMail;
use App\Mail\CustomerBookingConfirmationMail;
use App\Models\Book;
use App\Services\CardPaymentService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * A web booking where the customer chose card but never paid must not sit in
 * PENDING APPROVAL: it is cancelled and both the customer and the office are
 * told the booking was not completed.
 */
class UnpaidCardBookingTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        config(['mail.admin_recipients' => ['office@example.test']]);
    }

    // ---------------------------------------------------------------- helpers

    private function booking(array $overrides = []): Book
    {
        $booking = Book::create(array_merge([
            'booking_id' => 'BKG-T' . Str::random(8),
            'source' => 'web',
            'name' => 'Casey Customer',
            'email' => 'casey@example.test',
            'phone' => '07000 000000',
            'pickup' => 'Brighton, UK',
            'dropoff' => 'Gatwick Airport, UK',
            'pickup_date' => now()->addDays(3)->toDateString(),
            'pickup_time' => '10:00',
            'price' => 75,
            'amount_paid' => 0,
            'outstanding_amount' => 75,
            'payment_method' => 'stripe',
            'payment_status' => 'pending_payment',
            'stripe_session_id' => 'cs_test_' . Str::random(12),
            'status' => 'PENDING APPROVAL',
        ], $overrides));

        if (isset($overrides['created_at'])) {
            Book::where('id', $booking->id)->update(['created_at' => $overrides['created_at']]);
        }

        return $booking->fresh();
    }

    /** Stripe answers with the given session state; records whether the session was expired. */
    private function fakeStripe(string $status, string $paymentStatus, bool $expectExpire = false): void
    {
        $this->partialMock(CardPaymentService::class, function ($mock) use ($status, $paymentStatus, $expectExpire) {
            $mock->shouldReceive('retrieveSession')->andReturn((object) [
                'status' => $status, 'payment_status' => $paymentStatus, 'payment_intent' => 'pi_test_123',
            ]);
            $expectExpire
                ? $mock->shouldReceive('expireSession')->once()
                : $mock->shouldReceive('expireSession')->never();
        });
    }

    private function assertCancelledForNonPayment(Book $booking): void
    {
        $booking->refresh();
        $this->assertSame('CANCELLED', $booking->status);
        $this->assertSame('payment_failed', $booking->payment_status);
        $this->assertSame(CardPaymentService::CANCELLATION_REASON, $booking->cancellation_reason);

        Mail::assertSent(BookingPaymentIncompleteMail::class, fn ($m) => !$m->forAdmin && $m->hasTo('casey@example.test'));
        Mail::assertSent(BookingPaymentIncompleteMail::class, fn ($m) => $m->forAdmin && $m->hasTo('office@example.test'));
    }

    // ------------------------------------------------------------------ tests

    /** @test */
    public function backing_out_of_the_payment_page_cancels_the_booking_and_emails_both_parties(): void
    {
        $this->fakeStripe('open', 'unpaid', expectExpire: true);
        $booking = $this->booking();

        $this->get(route('booking.payment.cancelled', $booking->access_token))
            ->assertRedirect(route('booking.confirmation', $booking->access_token));

        $this->assertCancelledForNonPayment($booking);

        $this->get(route('booking.confirmation', $booking->access_token))
            ->assertOk()
            ->assertSee('Booking not completed');
    }

    /** @test */
    public function the_cancel_link_does_nothing_to_a_booking_that_is_already_paid(): void
    {
        $this->fakeStripe('complete', 'paid');
        $booking = $this->booking(['payment_status' => 'paid', 'amount_paid' => 75, 'outstanding_amount' => 0]);

        $this->get(route('booking.payment.cancelled', $booking->access_token));

        $this->assertSame('PENDING APPROVAL', $booking->fresh()->status);
        Mail::assertNothingSent();
    }

    /** @test */
    public function an_abandoned_checkout_is_cancelled_once_the_timeout_passes(): void
    {
        $this->fakeStripe('expired', 'unpaid');
        $stale = $this->booking(['created_at' => now()->subMinutes(45)]);
        $fresh = $this->booking(['created_at' => now()->subMinutes(5)]);

        $this->artisan('bookings:cancel-unpaid')->assertSuccessful();

        $this->assertCancelledForNonPayment($stale);
        $this->assertSame('PENDING APPROVAL', $fresh->fresh()->status);
    }

    /** @test */
    public function a_stale_booking_that_stripe_says_was_paid_is_recorded_as_paid_not_cancelled(): void
    {
        $this->fakeStripe('complete', 'paid');
        $booking = $this->booking(['created_at' => now()->subMinutes(45)]);

        $this->artisan('bookings:cancel-unpaid')->assertSuccessful();

        $booking->refresh();
        $this->assertSame('PENDING APPROVAL', $booking->status);
        $this->assertSame('paid', $booking->payment_status);
        $this->assertSame('pi_test_123', $booking->refund_transaction_reference);
        Mail::assertSent(CustomerBookingConfirmationMail::class);
        Mail::assertSent(AdminBookingNotificationMail::class);
        Mail::assertNotSent(BookingPaymentIncompleteMail::class);
    }

    /** @test */
    public function a_booking_is_left_alone_when_stripe_cannot_be_reached(): void
    {
        $this->partialMock(CardPaymentService::class, function ($mock) {
            $mock->shouldReceive('retrieveSession')->andThrow(new \RuntimeException('Stripe is down'));
        });
        $booking = $this->booking(['created_at' => now()->subMinutes(45)]);

        $this->artisan('bookings:cancel-unpaid')->assertSuccessful();

        $this->assertSame('PENDING APPROVAL', $booking->fresh()->status);
        Mail::assertNothingSent();
    }

    /** @test */
    public function pay_in_car_and_admin_created_bookings_are_never_swept(): void
    {
        $this->fakeStripe('expired', 'unpaid');
        $cash = $this->booking(['payment_method' => 'pay_in_car_cash', 'payment_status' => 'unpaid', 'stripe_session_id' => null, 'created_at' => now()->subDays(2)]);
        $admin = $this->booking(['source' => 'admin', 'created_at' => now()->subDays(2)]);

        $this->artisan('bookings:cancel-unpaid')->assertSuccessful();

        $this->assertSame('PENDING APPROVAL', $cash->fresh()->status);
        $this->assertSame('PENDING APPROVAL', $admin->fresh()->status);
    }

    /** @test */
    public function the_success_page_does_not_mark_an_unpaid_session_as_paid(): void
    {
        $this->fakeStripe('open', 'unpaid');
        $booking = $this->booking();

        $this->get('/success?session_id=' . $booking->stripe_session_id)
            ->assertRedirect(route('booking.confirmation', $booking->access_token));

        $this->assertSame('pending_payment', $booking->fresh()->payment_status);
        Mail::assertNothingSent();
    }

    /** @test */
    public function the_success_page_records_a_paid_session_once(): void
    {
        $this->fakeStripe('complete', 'paid');
        $booking = $this->booking();

        $this->get('/success?session_id=' . $booking->stripe_session_id);
        $this->get('/success?session_id=' . $booking->stripe_session_id);

        $this->assertSame('paid', $booking->fresh()->payment_status);
        Mail::assertSent(CustomerBookingConfirmationMail::class, 1);
    }
}
