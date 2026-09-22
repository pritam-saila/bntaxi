<?php

namespace App\Mail;

use App\Models\Book;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent to the customer once a booking request has been placed (cash) or paid
 * (Stripe). Carries the reference number, full details, cancel / contact links
 * and a PDF receipt attachment.
 */
class CustomerBookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Book $booking;

    public function __construct(Book $booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your BN Taxi booking – ' . $this->booking->booking_id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.customer-booking-confirmation',
            with: ['booking' => $this->booking],
        );
    }

    public function attachments(): array
    {
        $booking = $this->booking;

        return [
            Attachment::fromData(
                fn () => Pdf::loadView('pdf.booking-receipt', ['booking' => $booking])->output(),
                'receipt-' . $booking->booking_id . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
