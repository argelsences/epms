<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon;
use EPPMS;
use App\Event;

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
        if ( auth()->user()->can(['list ticket']) ){
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
        if ( auth()->user()->can(['edit ticket', 'add ticket']) ){
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

        if ( auth()->user()->can(['edit ticket']) ){
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
}
