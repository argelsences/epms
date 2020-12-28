<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendBookingEmail;
use Mail;

class SendBookingEmailJob implements ShouldQueue
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
     * Send booking email job to queue
     *
     * @return void
     */
    public function handle()
    {
        //
        /////dd($this->details['booking']->email, $this->details['booking']->first_name, $this->details['booking']->last_name);
        /////$department = Department::findOrFail($this->details['department_id']);
        
        // add department name in details
        /////$this->details['department_name'] = $department->name;
        
        $to = [
            [
                'email' => $this->details['booking']->email, 
                'name' => $this->details['booking']->first_name . ' ' . $this->details['booking']->last_name,
            ]
        ];
        
        // send the email
        Mail::to($to)->send(new SendBookingEmail($this->details));
    }
}
