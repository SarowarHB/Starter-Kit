<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DefaultMail extends Mailable
{
    use Queueable, SerializesModels;


    public $subject;
    public $body_message;

    public function __construct(string $subject, string $message)
    {
    //    dd($message);
        $this->subject = $subject;
        $this->body_message = $message;
    }


    public function envelope()
    {
        return new Envelope(
            subject: $this->subject,
        );
    }


    public function content()
    {
        return new Content(
            view: 'email.default',
        );
    }

    public function attachments()
    {
        return [];
    }
}
