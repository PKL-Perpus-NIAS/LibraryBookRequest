<?php

namespace App\Mail;

use App\Models\BookRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookAvailableMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookRequest; 

    public function __construct(BookRequest $bookRequest)
    {
        $this->bookRequest = $bookRequest;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hore! Usulan Buku Kamu Sudah Tersedia di Perpustakaan',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.book-available', 
        );
    }
}