<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $department = Department::findOrFail($this->details['department_id']);
        
        // add department name in details
        $this->details['department_name'] = $department->name;
        
        $to = [
            [
                'email' => $department->email, 
                'name' => $department->name,
            ]
        ];
        // send the email
        Mail::to($to)->send(new SendBookingEmail($this->details));
    }
}
