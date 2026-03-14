<?php

namespace App\Izin\Mail;

use App\Izin\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerified extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Akun Anda Telah Diverifikasi')
                    ->view('auth.email_verified')
                    ->with(['user' => $this->user]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Anda Telah Diverifikasi',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'auth.email-verified',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}