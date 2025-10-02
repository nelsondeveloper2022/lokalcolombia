<?php

namespace App\Mail;

use App\Models\User;
use App\Models\MarketComercioServicio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeBusinessRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $comercio;
    public $dashboardUrl;
    public $completeInfoUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, MarketComercioServicio $comercio)
    {
        $this->user = $user;
        $this->comercio = $comercio;
        $this->dashboardUrl = route('dashboard');
        $this->completeInfoUrl = route('dashboard') . '#complete-info';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Bienvenido a Lokal Colombia! - Registro exitoso',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.welcome-business',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
