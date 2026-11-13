<?php

namespace App\Services;

use App\Mail\AdminBookingNotificationMail;
use App\Mail\BookingPaymentIncompleteMail;
use App\Mail\CustomerBookingConfirmationMail;
use App\Models\Book;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Online card payment for a web booking: opens the Stripe Checkout session,
 * records the payment when it lands, and cancels the booking (telling the
 * customer and the office) when the customer never completes it.
 */
class CardPaymentService
{
    /** Stripe will not expire a Checkout session sooner than this. */
    public const STRIPE_MIN_SESSION_MINUTES = 30;

    public const CANCELLATION_REASON = 'Card payment was not completed.';

    /**
     * How long a card booking may sit unpaid before it is cancelled.
     */
    public function timeoutMinutes(): int
    {
        return max(1, (int) Setting::get('unpaid_card_booking_timeout_minutes', self::STRIPE_MIN_SESSION_MINUTES));
    }

    /**
     * Open a Checkout session for the booking and return the URL to send the
     * customer to.
     */
    public function startCheckout(Book $booking): string
    {
        $stripe = $this->stripe();

        $product = $stripe->products->create(['name' => 'Booking ' . $booking->booking_id]);
        $price = $stripe->prices->create([
            'product' => $product->id,
            'unit_amount' => (int) round(floatval($booking->price) * 100),
            'currency' => 'GBP',
        ]);

        $session = $stripe->checkout->sessions->create([
            'line_items' => [[
                'price' => $price->id,
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'client_reference_id' => $booking->booking_id,
            'customer_email' => $booking->email,
            // The payment page closes itself once the booking would be cancelled.
            'expires_at' => now()->addMinutes(max($this->timeoutMinutes(), self::STRIPE_MIN_SESSION_MINUTES) + 1)->timestamp,
            'success_url' => url('success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => route('booking.payment.cancelled', $booking->access_token),
        ]);

        $booking->stripe_session_id = $session->id;
        $booking->save();

        return $session->url;
    }

    public function retrieveSession(string $sessionId)
    {
        return $this->stripe()->checkout->sessions->retrieve($sessionId);
    }

    public function expireSession(string $sessionId): void
    {
        $this->stripe()->checkout->sessions->expire($sessionId);
    }

    /**
     * Record a successful online payment and send the booking emails.
     */
    public function markPaid(Book $booking, ?string $paymentIntentId): void
    {
        $booking->update([
            'status' => 'PENDING APPROVAL',
            'payment_method' => 'stripe',
            'payment_status' => 'paid',
            'payment_actual_method' => 'stripe',
            'amount_paid' => $booking->price,
            'outstanding_amount' => 0,
            'payment_date' => now(),
            'payment_confirmed_by' => 'Stripe (online)',
            'refund_transaction_reference' => $paymentIntentId,
        ]);

        $booking->logTimeline('Payment Received', 'Online payment of £' . number_format($booking->price, 2) . ' received successfully via Stripe.', 'Stripe');

        try {
            Mail::to($booking->email)->send(new CustomerBookingConfirmationMail($booking));
            Mail::to(Book::adminNotificationRecipients())->send(new AdminBookingNotificationMail($booking));
            $booking->logTimeline('Confirmation Emails Sent', 'Customer confirmation (with receipt) and admin notification sent.', 'System');
        } catch (\Exception $e) {
            $booking->logTimeline('Confirmation Email Failed', 'Could not send booking emails: ' . $e->getMessage(), 'System');
        }
    }

    /**
     * Cancel a card booking whose payment was never completed, and email the
     * customer and the office. Stripe is asked first, so a booking that was
     * in fact paid is recorded as paid instead of being cancelled.
     *
     * @return string 'cancelled' | 'paid' | 'skipped'
     */
    public function cancelIfUnpaid(Book $booking, string $trigger): string
    {
        if (!$booking->isAwaitingCardPayment()) {
            return 'skipped';
        }

        if ($booking->stripe_session_id) {
            try {
                $session = $this->retrieveSession($booking->stripe_session_id);

                if ($session->payment_status === 'paid') {
                    $this->markPaid($booking, $session->payment_intent);
                    return 'paid';
                }

                if ($session->status === 'complete') {
                    // Checkout finished but the money has not settled yet - leave it for the next pass.
                    return 'skipped';
                }

                if ($session->status === 'open') {
                    // Close the payment page so the customer cannot pay for a cancelled booking.
                    $this->expireSession($booking->stripe_session_id);
                }
            } catch (\Throwable $e) {
                // Without Stripe's answer we cannot be sure it is unpaid; try again on the next pass.
                Log::warning("Could not verify card payment for booking {$booking->booking_id}: " . $e->getMessage());
                return 'skipped';
            }
        }

        $booking->status = 'CANCELLED';
        $booking->cancelled_at = now();
        $booking->cancelled_by = 'System';
        $booking->cancellation_reason = self::CANCELLATION_REASON;
        $booking->payment_status = 'payment_failed';
        $booking->save();

        $booking->logTimeline('Booking Not Completed', 'Booking cancelled automatically: card payment was not completed (' . $trigger . ').', 'System');

        $this->sendPaymentIncompleteEmails($booking);

        return 'cancelled';
    }

    /**
     * Cancel every card booking that has been left unpaid past the timeout.
     *
     * @return array{cancelled:int, paid:int, skipped:int}
     */
    public function cancelAbandoned(): array
    {
        $results = ['cancelled' => 0, 'paid' => 0, 'skipped' => 0];

        $bookings = Book::where('source', 'web')
            ->where('payment_method', 'stripe')
            ->where('payment_status', 'pending_payment')
            ->where('status', 'PENDING APPROVAL')
            ->where('created_at', '<=', now()->subMinutes($this->timeoutMinutes()))
            ->get();

        foreach ($bookings as $booking) {
            $results[$this->cancelIfUnpaid($booking, 'checkout abandoned')]++;
        }

        return $results;
    }

    protected function sendPaymentIncompleteEmails(Book $booking): void
    {
        $sent = [];
        $failed = [];

        // Sent separately so a bad customer address cannot stop the office hearing about it.
        try {
            Mail::to($booking->email)->send(new BookingPaymentIncompleteMail($booking));
            $sent[] = 'customer';
        } catch (\Exception $e) {
            $failed[] = 'customer (' . $e->getMessage() . ')';
        }

        try {
            Mail::to(Book::adminNotificationRecipients())->send(new BookingPaymentIncompleteMail($booking, true));
            $sent[] = 'admin';
        } catch (\Exception $e) {
            $failed[] = 'admin (' . $e->getMessage() . ')';
        }

        if ($sent) {
            $booking->logTimeline('Payment Not Completed Emails Sent', 'Notified: ' . implode(', ', $sent) . '.', 'System');
        }
        if ($failed) {
            $booking->logTimeline('Payment Not Completed Email Failed', 'Could not notify: ' . implode(', ', $failed) . '.', 'System');
        }
    }

    protected function stripe(): \Stripe\StripeClient
    {
        return new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }
}
