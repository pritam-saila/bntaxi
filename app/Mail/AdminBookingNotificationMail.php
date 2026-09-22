<?php

namespace App\Mail;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Dispatch-desk notification: fires when a new booking lands so staff can
 * action it. Job-sheet tone, full contact + route + payment details, no receipt.
 */
class AdminBookingNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Book $booking;

    public function __construct(Book $booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        $b = $this->booking;

        return new Envelope(
            subject: 'New booking ' . $b->booking_id . ' – '
                . $b->pickup . ' → ' . $b->dropoff
                . ' (' . trim(($b->pickup_date ?? '') . ' ' . ($b->pickup_time ?? '')) . ')',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-booking-notification',
            with: ['booking' => $this->booking],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
