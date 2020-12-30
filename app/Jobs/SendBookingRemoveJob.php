<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendBookingRemoveEmail;
use Mail;

class SendBookingRemoveJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        //
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $to = [
            [
                'email' => $this->details['book']['email'], 
                'name' => $this->details['book']['first_name'] . ' ' . $this->details['book']['last_name'],
            ]
        ];
        
        // send the email
        Mail::to($to)->send(new SendBookingRemoveEmail($this->details));
    }
}
