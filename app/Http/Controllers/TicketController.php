<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon;
use EPPMS;
use App\Event;
use App\Book;
use App\BookItem;
use App\Attendee;

class TicketController extends Controller
{
    protected $tickets;

    public function __construct(Ticket $tickets){
        $this->tickets = $tickets;
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
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
    /**
     * API function
     * 
     * List all speakers
     * 
     */
    public function list($event){
        /*if ( auth()->user()->can(['list ticket']) ){
            return response('Unauthorized', 403);
        }*/

        if (auth()->user()->hasPermissionTo('list ticket', 'api') ){
            return response('Unauthorized', 403);
        }

        $theTickets = Ticket::where('event_id', $event)->orderBy('title', 'ASC')->get();
        ///dd($theTickets);
        return response()->json(($theTickets));
    }
    /**
     * Update the specified resource in storage.
     * 
     * API
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upsert(Request $request)
    {
        /*if ( auth()->user()->can(['edit ticket', 'add ticket']) ){
            return response('Unauthorized', 403);
        }*/

        if (auth()->user()->hasPermissionTo('edit ticket', 'api') && auth()->user()->hasPermissionTo('add ticket', 'api') ){
            return response('Unauthorized', 403);
        }

        $upsertSuccess = false;
        // retrieve payload
        $ticket = $request->post('payload');
        // set dates
        $ticket['start_book_date'] = Carbon::parse($ticket['start_book_datetime']);
        $ticket['end_book_date'] = Carbon::parse($ticket['end_book_datetime']);
        
        $ticket = EPPMS::setAuthorship($ticket);

        //dd($ticket);

        if ( $ticket['id'] ){
            // retrieve the ticket object
            $theTicket = $this->tickets->findOrFail($ticket['id']);
            // update the user object with updated details
            $theTicket = tap($theTicket)->update($ticket);
        }
        else{
            // set default values for new ticket object
            /////$ticket['created_by'] = auth()->user()->id;
            $ticket['is_paused'] = 0;
            $ticket['is_hidden'] = 0;

            $theTicket = $this->tickets->create($ticket);
            $upsertSuccess = ($theTicket->id) ? true : false;
        }
        // return the same data compared to list to ensure using the same 
        $success = ($theTicket) ? true : false;
        return ['success' => $success, 'item' => $theTicket];
    }

    /**
     * API function
     * Pause a ticket
     */
    public function pause(Request $request) {

        /*if ( auth()->user()->can(['edit ticket']) ){
            return response('Unauthorized', 403);
        }*/

        if (auth()->user()->hasPermissionTo('edit ticket', 'api') ){
            return response('Unauthorized', 403);
        }
        
        $ticketID = $request->post('payload');
        $ticket = $this->tickets->findOrFail($ticketID);
        // save the previous pause value of ticket
        $ticketIsPaused = $ticket->is_paused;

        if ( $ticket ){
            $ticket->is_paused = !$ticket->is_paused;
            $ticket->update();
        }

        $success = ($ticketIsPaused !== $ticket->is_paused ) ? true : false;
        return ['success' => $success, 'item' => $ticket];
    }
    /**
     * Checkout from event
     */
    public function checkout(Request $request){
        
        $attendees = array_filter($request->input('attendee'));
        $bookee = $request->input('bookee');
        $event = $request->input('event');
        /*
        id
        first_name
        last_name
        email
        booking_reference
        */

        //dd($attendees, $bookee,$event);

        // the booking
        // remove later
        //dd($bookee);
        
        $theBook = Book::create([
            'first_name' => $bookee['first_name'],
            'last_name' => $bookee['last_name'],
            'email' => $bookee['email'],
            'booking_reference' => substr(md5(time()), 0, 10),
            'reserve_status_id' => 1,
        ]);
        
        // the book items

        
        $theTicketIDs = array_keys($attendees);

        foreach ($theTicketIDs as $theTicketID){
            $theTicket = Ticket::findOrFail($theTicketID);

            ?><pre><?php //print_r($attendees[$theTicketID]); ?></pre><?php
            // create book item
            
            
            $theBookItems = BookItem::create([
                'title' => $theTicket->title,
                'quantity' => count($attendees[$theTicketID]),
                'book_id' => $theBook->id
            ]);
            
        }

        // the attendees

        foreach($attendees as $tkt => $attendee){
            ?><pre><?php print_r($tkt); ?></pre><?php 
            ?><pre><?php print_r($attendee); ?></pre><?php
            // get the ticket details
            //$theTicket = Ticket::findOrFail($tkt);
            
            /*
            $theBookItems = BookItems::create([
                'title' =>
                'quantity' =>
                'book_id' =>
            ]);
            */
            foreach($attendee as $att){
                ?><pre><?php print_r($att); ?></pre><?php 
                
                $theAttendee = Attendee::create([
                    'first_name' => $att['first_name'],
                    'last_name' => $att['last_name'],
                    'email' => $att['email'],
                    'private_reference_number' => $att['first_name'],
                    'reference_index' => substr(md5(time()), 0, 15),
                    'event_id' => $event['event_id'],
                    'book_id' => $theBook->id,
                    'ticket_id' => $tkt,
                ]);
                
            }
            
            
            
        }
        dd();
        /* remove later
        $theBookItems = BookItems::create([
            'title' =>
            'quantity' =>
            'book_id' =>
        ]);
        */ 

        
        
        
    }
}
