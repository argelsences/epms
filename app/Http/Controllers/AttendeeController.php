<?php

namespace App\Http\Controllers;

use App\Attendee;
use Illuminate\Http\Request;
use App\Jobs\SendBookingCancelJob;

class AttendeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendee  $attendee
     * @return \Illuminate\Http\Response
     */
    public function show(Attendee $attendee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attendee  $attendee
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendee $attendee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendee  $attendee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendee $attendee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendee  $attendee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendee $attendee)
    {
        if (auth()->user()->hasPermissionTo('delete attendee', 'api') ){
            return response('Unauthorized', 403);
        }


        $theAttendee = [
            'department' => [
                'email' => $attendee->event->department->email,
                'name' => $attendee->event->department->name
            ],
            'event' => [
                'title' => $attendee->event->title,
                'start_date' => $attendee->event->startDateFormatted(),
            ],
            'attendee' => [
                'first_name' => $attendee->first_name,
                'last_name' => $attendee->last_name,
                'private_reference_number' => $attendee->private_reference_number,
            ],
            'book' => [
                'email' => $attendee->book->email,
                'first_name' => $attendee->book->first_name,
                'last_name' => $attendee->book->last_name,
                'booking_reference' => $attendee->book->booking_reference
            ],
        ];
        // send email job
        $cancelBookingEmail = $this->cancel_booking_email( $theAttendee );

        $attendee->delete();
    
        return ['success' => true];
    }

    /**
     * Description: Function to send email to bookee after cancellation of attendee
     * 
     */
    private function cancel_booking_email($theAttendee){

        SendBookingCancelJob::dispatch($theAttendee)
                ->delay(now()->addSeconds(5)); 

        return ['success' => true, 'message' => config('eppms.messages.frontend_success') ];
       
    }
}
