<?php

namespace App\Mail;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent when a customer chose to pay by card but never completed the payment,
 * so the booking was cancelled. One copy tells the customer no taxi is booked;
 * the admin copy carries their contact details so the office can follow up.
 */
class BookingPaymentIncompleteMail extends Mailable
{
    use Queueable, SerializesModels;

    public Book $booking;
    public bool $forAdmin;

    public function __construct(Book $booking, bool $forAdmin = false)
    {
        $this->booking = $booking;
        $this->forAdmin = $forAdmin;
    }

    public function envelope(): Envelope
    {
        $b = $this->booking;

        return new Envelope(
            subject: $this->forAdmin
                ? 'Booking not completed (payment not made) ' . $b->booking_id . ' – ' . $b->name
                : 'Your BN Taxi booking was not completed – payment not received – ' . $b->booking_id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-payment-incomplete',
            with: ['booking' => $this->booking, 'forAdmin' => $this->forAdmin],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
