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
use App\Setting;

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

        // the booking
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
            // create book item
            
            $theBookItems[] = BookItem::create([
                'title' => $theTicket->title,
                'quantity' => count($attendees[$theTicketID]),
                'book_id' => $theBook->id
            ]);

            // create pivot table entry book_tickets
            $theTicket->books()->sync($theBook);
            
        }

        // the attendees
        $counter = 1;
        foreach($attendees as $tkt => $attendee){
            foreach($attendee as $att){
                $theAttendees[] = Attendee::create([
                    'first_name' => $att['first_name'],
                    'last_name' => $att['last_name'],
                    'email' => $att['email'],
                    'private_reference_number' => substr(md5(time()), 0, 15),
                    'reference_index' => $counter,
                    'event_id' => $event['event_id'],
                    'book_id' => $theBook->id,
                    'ticket_id' => $tkt,
                ]);
                $counter++;
            }    
        }
        
        $theTicketDetails = [
            'booking' => $theBook,
            'booking_items' => $theBookItems,
            'attendees' => $theAttendees,
        ];

        $success = ($theBook && $theBookItems && $theAttendees  ) ? true : false;
        return ['success' => $success, 'item' => $theBook->booking_reference];
        
    }

    /**
     * Displays the order details based on reference number
     */
    public function booking_details(Request $request, $reference) {
        
        $is_embedded = null;

        if ($request->exists('is_embedded')) {
            $is_embedded = $request->query('is_embedded');
        }

        // the booking
        $booking = Book::where('booking_reference',$reference)->first();

        if (!$booking) {
            abort(404);
        }

        // attendees
        $attendees = $booking->attendees;

        // booking items
        $book_items = $booking->book_items;

        // the settings
        $settings = Setting::all(['name', 'value']);
        $objSettings = [];

        foreach ($settings as $setting){
            $value = $setting->value;

            if (strpos($setting->name , 'is_') !== false)
                $value = boolval($setting->value);

            $objSettings[$setting->name] = $value;
        }
        // end of settings

        $event = Event::findOrFail($booking->tickets->first()->event_id);

        $department = $event->department;

        return view('front.book.homepage', compact(
            'booking',
            'book_items',
            'attendees',
            'objSettings',
            'event',
            'department'
        ));
    }

    /**
     * Allows a user to download ticket in PDF format
     *
     * @param Request $request
     * @param $order_reference
     * @return \Illuminate\View\View
     */
    public function booking_tickets(Request $request, $reference)
    {
        // the booking
        $booking = Book::where('booking_reference',$reference)->first();

        if (!$booking) {
            abort(404);
        }

        //$images = [];
        //$imgs = $booking->event->images;
        //foreach ($imgs as $img) {
            //$images[] = base64_encode(file_get_contents(public_path($img->image_path)));
        //}
        // get poster from the event
        $the_poster = '';
        $event = Event::findOrFail($booking->tickets->first()->event_id);
        if ($event->poster->file_path){
            $the_poster = base64_encode(file_get_contents(public_path($event->poster->file_path)));
        }
        elseif ($event->poster->poster_code){
            $the_poster = $event->poster->poster_code;
        }

        $data = [
            'booking'   => $booking,
            'event'     => $event,
            'tickets'   => $booking->tickets,
            'attendees' => $booking->attendees,
            'css'       => file_get_contents(public_path('css/ticket.css')),
            'logo'      => base64_encode(file_get_contents(public_path($event->department->logo_path))),
            'poster'    => $the_poster,
        ];

        dd($data);

        if ($request->exists('download')) {
            if ($request->get('download') == '1') {
                return PDF::html('front.pdf.ticket-pdf', $data, 'Tickets');
            }
        }

        
        return view('Public.ViewEvent.Partials.PDFTicket', $data);
    }
}
