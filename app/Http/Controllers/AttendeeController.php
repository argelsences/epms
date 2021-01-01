<?php

namespace App\Http\Controllers;

use App\Attendee;
use App\Event;
use App\Ticket;
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
        if (auth()->user()->hasPermissionTo('edit attendee', 'api') ){
            return response('Unauthorized', 403);
        }

        $att = $attendee::findOrFail($request->input('id'));

        $theAttendee = $att->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
        ]);

        $success = ($theAttendee) ? true : false;

        return [ 'success' => $success, 'item' => $theAttendee ]; 
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

        

        $ticketID = $attendee->ticket->id;

        $theTicket = Ticket::findOrFail($ticketID);
        $bookedCountPerTicket = $theTicket->attendees()->count() - 1;
        $bookedCountPerTicketUpdated = $theTicket->update([
            'quantity_booked' => $bookedCountPerTicket,
        ]);

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
    
    /**
     * API function to list all bookings of an event
     * @params event_id the id of the event
     * @return json object containing all bookings related to the event
     */
    public function list(Attendee $model, $event_id){
        
        if (auth()->user()->hasPermissionTo('list attendee', 'api') ){
            return response('Unauthorized', 403);
        }
        
        $attendees = $model::with(['book','ticket'])->where('event_id', $event_id)->get();
        
        return response()->json($attendees);
    }

    /**
     * Admin Function to export attendees to CSV file
     * 
     * @param request object containing details about the booking
     */
    public function exportToCSV(Attendee $model) {

        if (auth()->user()->hasPermissionTo('export booking', 'web') ){
            return response('Unauthorized', 403);
        }

        //$fileName = Str::random() . '.csv';
        $date = date('d-m-Y-g.i.a');
        $filename = 'attendess-as-of-' . $date . '.csv';

        $attendees = $model::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        // "First Name","Last Name","Email","Reference","Amount"
        $columns = array('First Name','Last Name','Email', 'Ticket ID', 'Reference','Ticket Name');

        $callback = function() use($attendees, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($attendees as $attendee) {
                $row['First Name']  = $attendee->first_name;
                $row['Last Name']    = $attendee->last_name;
                $row['Email']    = $attendee->email;
                $row['Ticket ID']  = $attendee->private_reference_number;
                $row['Reference']  = $attendee->book->booking_reference;
                $row['Ticket Name']  = $attendee->ticket->title;

                fputcsv($file, array($row['First Name'], $row['Last Name'], $row['Email'], $row['Ticket ID'],  $row['Reference'], $row['Ticket Name']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display printable page of attendees
     *
     * @param $event_id
     * @return View
     */
    public function displayPrintableAttendees(Event $event)
    {
        $event = $event;
        $attendees = $event->attendees()->orderBy('first_name')->get();

        return view('admin.print.attendees', compact('event','attendees') );
    }
}
