<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageBody;
    public $fromEmail;
    public $subject;

    public function __construct($messageBody, $fromEmail, $subject)
    {
        $this->messageBody = $messageBody;
        $this->fromEmail = $fromEmail;
        $this->subject = $subject;
    }

    public function build()
    {
        return $this->from($this->fromEmail)
                    // ici la vue pour gerer l'aspet de l'affichage du message a emvoyer
                    ->view('emails.message')
                    // ceci est l'objet du mail
                    ->subject($this->subject)
                    ->with([
                        'fromEmail' => $this->fromEmail
                    ]);
    }
}