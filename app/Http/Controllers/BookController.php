<?php

namespace App\Http\Controllers;

use App\Book;
use App\Event;
use App\Ticket;
use App\Attendee;
use App\BookItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Jobs\SendBookingRemoveJob;

class BookController extends Controller
{
    protected $bookings;

    public function __construct(Book $bookings){
        $this->bookings = $bookings;
    }
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
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * API Function
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book) {
        //
        /*if (auth()->user()->hasPermissionTo('edit booking', 'api') ){
            return response('Unauthorized', 403);
        }*/

        if ( !auth()->user()->can(['edit booking']) ){
            return response('Unauthorized', 403);
        }

        $booking = $book::findOrFail($request->input('id'));
        //dd($booking);
        $theBooking = $booking->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
        ]);

        $success = ($theBooking) ? true : false;

        return [ 'success' => $success, 'item' => $theBooking ]; 
    }

    /**
     * API function to list all bookings of an event
     * @params event_id the id of the event
     * @return json object containing all bookings related to the event
     */
    public function list(Book $model, $event_id){
        
        /*if (auth()->user()->hasPermissionTo('list booking', 'api') ){
            return response('Unauthorized', 403);
        }*/

        if ( !auth()->user()->can(['list booking']) ){
            return response('Unauthorized', 403);
        }
        
        $bookings = $model::with(['reserve_status','attendees','tickets','book_items'])->where('event_id', $event_id)->get();
        
        return response()->json($bookings);
    }

    /**
     * Admin Function to export bookings to CSV file
     * 
     * @param request object containing details about the booking
     */
    public function exportToCSV(Book $model, $event_id) {

        /*if (auth()->user()->hasPermissionTo('export booking', 'web') ){
            return response('Unauthorized', 403);
        }*/
        if ( !auth()->user()->can(['export booking']) ){
            return response('Unauthorized', 403);
        }

        //$fileName = Str::random() . '.csv';
        $date = date('d-m-Y-g.i.a');
        $filename = 'booking-as-of-' . $date . '.csv';

        //$books = $model::all();
        $books = $model::where('event_id', $event_id)->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        // "First Name","Last Name","Email","Reference","Amount"
        $columns = array('First Name','Last Name','Email','Reference','Amount');

        $callback = function() use($books, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($books as $book) {
                $row['First Name']  = $book->first_name;
                $row['Last Name']    = $book->last_name;
                $row['Email']    = $book->email;
                $row['Reference']  = $book->booking_reference;
                $row['Amount']  = 'FREE';

                fputcsv($file, array($row['First Name'], $row['Last Name'], $row['Email'], $row['Reference'], $row['Amount']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attendee  $attendee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        /*if (auth()->user()->hasPermissionTo('delete booking', 'api') ){
            return response('Unauthorized', 403);
        }*/

        if ( !auth()->user()->can(['delete booking']) ){
            return response('Unauthorized', 403);
        }

        $theBooking = [
            'department' => [
                'email' => $book->event->department->email,
                'name' => $book->event->department->name
            ],
            'event' => [
                'title' => $book->event->title,
                'start_date' => $book->event->startDateFormatted(),
            ],
            'attendees' => $book->attendees,
            'book' => [
                'email' => $book->email,
                'first_name' => $book->first_name,
                'last_name' => $book->last_name,
                'booking_reference' => $book->booking_reference
            ],
        ];

        // send email job
        $removeBookingEmail = $this->remove_booking_email( $theBooking );

        // delete all attendees
        $deleteAttendees = Attendee::where('book_id', $book->id)->delete();
        $bookItems = BookItem::where('book_id',$book->id)->delete();
        $book->tickets()->detach();
        $book->delete();
    
        return ['success' => true];
    }

    /**
     * Description: Function to send email to bookee after cancellation of attendee
     * 
     */
    private function remove_booking_email($theBooking){

        SendBookingRemoveJob::dispatch($theBooking)
                ->delay(now()->addSeconds(5)); 

        return ['success' => true, 'message' => config('eppms.messages.frontend_success') ];
       
    }
}
