<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Post $post,
        public string $customTitle
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->customTitle,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.post-notification', // Kita akan buat file view ini
        );
    }
}