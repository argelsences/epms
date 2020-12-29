<?php

namespace App\Http\Controllers;

use App\Book;
use App\Event;
use App\Ticket;
use Illuminate\Http\Request;

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        //
    }
    /**
     * API function to list all bookings of an event
     * @params event_id the id of the event
     * @return json object containing all bookings related to the event
     */
    public function list(Book $model, $event_id){
        
        if (auth()->user()->hasPermissionTo('list booking', 'api') ){
            return response('Unauthorized', 403);
        }
        
        $bookings = $model::with(['reserve_status','attendees','tickets'])->where('event_id', $event_id)->get();
        
        return response()->json($bookings);
    }

    /**
     * API function
     * Cancel a booking
     * @param request object containing details about the booking
     */
    public function cancel(Request $request) {

        /*if ( auth()->user()->can(['edit ticket']) ){
            return response('Unauthorized', 403);
        }*/

        if (auth()->user()->hasPermissionTo('edit booking', 'api') ){
            return response('Unauthorized', 403);
        }
        
        $bookingID = $request->id;
        $booking = Book::findOrFail($bookingID);
        dd($booking->tickets->count());
        // save the previous pause value of ticket
        $ticketIsPaused = $ticket->is_paused;

        if ( $ticket ){
            $ticket->is_paused = !$ticket->is_paused;
            $ticket->update();
        }

        $success = ($ticketIsPaused !== $ticket->is_paused ) ? true : false;
        return ['success' => $success, 'item' => $ticket];
    }
}
