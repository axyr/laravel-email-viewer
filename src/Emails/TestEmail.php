<?php

namespace Axyr\EmailViewer\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly string $text = '')
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject
        );
    }

    public function content(): Content
    {
        return new Content('email-viewer::emails.test', with: [
            'subject' => $this->subject,
            'text' => $this->text,
        ]);
    }

    public function attachments(): array
    {
        return [];
    }
}
