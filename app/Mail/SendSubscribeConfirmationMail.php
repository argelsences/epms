<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendSubscribeConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        //
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $details = $this->details;

        return $this->view('front.email.subscriber-confirmation', compact('details'))
                    ->from($details['department']['email'], $details['department']['name'])
                    ->replyTo($details['department']['email'], $details['department']['name'])
                    ->subject("Subscription Confirmation for " . $details['department']['name'] );
    }
}
