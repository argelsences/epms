<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use EPPMS;

class EventController extends Controller
{
    protected $events;

    public function __construct(Event $events){
        $this->events = $events;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.events.list');
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
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
    /**
     * API function
     * 
     * List all departments
     * 
     */
    public function list(Event $model){
        
        if ( auth()->user()->can(['list event']) ){
            return response('Unauthorized', 403);
        }

        $events = $model::with(['venue','speakers'])->orderBy('title', 'ASC')->get();

        return response()->json($events);
    }
    /**
     * API Update and Insertdd($events->speakers());
     */
    public function upsert(Request $request){

        if ( auth()->user()->can(['list event']) ){
            return response('Unauthorized', 403);
        }
        /////dd($request->all());
        $upsertSuccess = false;
        $event = $request->post('payload');
        $event['barcode_type'] = (!$event['barcode_type']) ? 'QRCODE' : '';
        $event['start_date'] = Carbon::parse($event['start_date']);
        $event['end_date'] = Carbon::parse($event['end_date']);
        // Set event edited by and created by
        $event = EPPMS::setEventAuthorship($event);

        if ( $event['id'] ){
            // retrieve the user object
            $theEvent = $this->events->findOrFail($event['id']);
            // update the user object with updated details
            $theEvent = tap($theEvent)->update($event);
            // make sure that the speakers variable is an array.
            // in the list function, we pass speakers as object to simplify the query
            // however, when update is performed and no speaker is selected, the request is passing speaker untouched
            // and the values are in object
            //$the_speakers = $event['speakers'];
            if (strpos(json_encode($event['speakers']), 'id') > 0 ) {
                $event['speakers'] = array_column($event['speakers'], 'id');
            }
            
            $theEvent->speakers()->sync( $event['speakers'] );
        }
        else{
            $theEvent = $this->events->create($event);
            // attach speakers to event
            $theSpeakers = $theEvent->speakers()->attach($event['speakers']);
            $theEvent = $theEvent->fresh();

            $theEvent = Event::with(['venue','speakers'])->find($theEvent->id);
            /////dd($theEvents);

            $upsertSuccess = ($theEvent->id) ? true : false;
        }
        // return the same data compared to list to ensure using the same 
        $success = ($theEvent) ? true : false;
        return ['success' => $success, 'item' => $theEvent];
    }
}
