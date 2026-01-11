<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\ContactMessage;

class ContactReply extends Mailable
{
    use Queueable, SerializesModels;

    // JANGAN gunakan nama $message. Gunakan $contact.
    public $contact;
    public $replyContent;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactMessage $contact, string $replyContent)
    {
        // Menyimpan data ke property public agar otomatis bisa diakses di Blade
        $this->contact = $contact;
        $this->replyContent = $replyContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Mengambil subjek dari pesan asli pelanggan
            subject: 'Balasan: ' . $this->contact->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact_reply',
            // Variabel ini yang akan dipanggil di resources/views/emails/contact_reply.blade.php
            with: [
                'contact' => $this->contact,
                'replyContent' => $this->replyContent,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
