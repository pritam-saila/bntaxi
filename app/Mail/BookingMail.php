<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Status-change notification for a booking (confirmed / rejected / cancelled /
 * payment update). The booking receipt PDF is attached when the booking has
 * been CONFIRMED so the customer always has a receipt with the confirmation.
 */
class BookingMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     */
    public function __construct($data) {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $ref = $this->data->booking_id ?? null;
        $status = $this->data->status ?? null;

        $subject = match ($status) {
            'CONFIRMED' => 'Your BN Taxi booking is confirmed',
            'REJECTED'  => 'Update on your BN Taxi booking request',
            'CANCELLED' => 'Your BN Taxi booking has been cancelled',
            default     => 'Your BN Taxi booking',
        };

        if ($ref) {
            $subject .= ' – ' . $ref;
        }

        return new Envelope(subject: $subject);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $booking = $this->data;

        // Only a confirmed booking gets a receipt attached; rejections and
        // cancellations should not carry one.
        if (($booking->status ?? null) !== 'CONFIRMED' || empty($booking->access_token)) {
            return [];
        }

        return [
            Attachment::fromData(
                fn () => Pdf::loadView('pdf.booking-receipt', ['booking' => $booking])->output(),
                'receipt-' . ($booking->booking_id ?? 'booking') . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
