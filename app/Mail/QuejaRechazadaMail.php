<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuejaRechazadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $queja;

    /**
     * Create a new message instance.
     */
    public function __construct($queja)
    {
        $this->queja = $queja;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Notificación: Queja Rechazada')
                    ->view('emails.quejaRechazada');
    }
}
