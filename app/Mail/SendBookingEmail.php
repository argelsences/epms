<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use EPPMS;

class SendBookingEmail extends Mailable
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

        $ticket = EPPMS::booking_tickets($details['booking']->booking_reference, 0, 1);
        return $this->view('front.email.ticket', compact('details'))
                    ->replyTo($details['event']->department->email, $details['event']->department->name)
                    ->subject('Your ticket for ' . $details['event']->title . ' | EPPMS')
                    ->attachData($ticket, $details['booking']->booking_reference . '.pdf');
    }
}
