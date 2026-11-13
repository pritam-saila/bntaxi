<?php

namespace App\Mail;

use App\Models\DriverDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Admin notification: a driver uploaded (or replaced) a document and it's
 * waiting for review. Fired from DriverDocumentService::upload() - only when
 * the driver did it themselves, not when an admin uploads on their behalf.
 */
class DriverDocumentUploadedMail extends Mailable
{
    use Queueable, SerializesModels;

    public DriverDocument $document;
    public bool $isReplacement;

    public function __construct(DriverDocument $document, bool $isReplacement = false)
    {
        $this->document = $document;
        $this->isReplacement = $isReplacement;
    }

    public function envelope(): Envelope
    {
        $driverName = $this->document->driver->name;
        $label = $this->document->definition()['short'] ?? $this->document->type;

        return new Envelope(
            subject: ($this->isReplacement ? 'Document re-uploaded' : 'New document uploaded')
                . " – {$driverName} – {$label}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.driver-document-uploaded',
            with: [
                'document'      => $this->document,
                'driver'        => $this->document->driver,
                'isReplacement' => $this->isReplacement,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
