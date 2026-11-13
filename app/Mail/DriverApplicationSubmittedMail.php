<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Admin notification: a new driver has just registered and is waiting to be
 * verified. Fired once, from WebController::postdriverregister().
 */
class DriverApplicationSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $driver;

    public function __construct(User $driver)
    {
        $this->driver = $driver;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New driver application – ' . $this->driver->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.driver-application-submitted',
            with: ['driver' => $this->driver],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
