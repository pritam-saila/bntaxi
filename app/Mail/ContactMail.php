<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Enquiry submitted through the public "Contact Us" form.
 */
class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        $name = $this->data['name'] ?? 'Website visitor';

        return new Envelope(
            subject: 'Contact enquiry from ' . $name,
            replyTo: !empty($this->data['email'])
                ? [new Address($this->data['email'], $name)]
                : [],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            with: ['data' => $this->data],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
