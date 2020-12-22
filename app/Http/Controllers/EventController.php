<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use EPPMS;
use App\Department;
use App\Setting;
use App\Http\Requests\ContactFormRequest;
use App\Jobs\SendEmailFrontendJob;

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
        
        /*if ( auth()->user()->can(['list event']) ){
            return response('Unauthorized', 403);
        }*/

        if (auth()->user()->hasPermissionTo('list event', 'api') ){
            return response('Unauthorized', 403);
        }

        $events = $model::with(['venue','speakers','tickets'])->orderBy('title', 'ASC')->get();
        /*
        $tickets = [];
        foreach($events as $event){
            $tickets[] = $event->tickets();
        }
        dd($tickets);
        */
        //dd($events);

        return response()->json($events);
    }
    /**
     * API Update and Insertdd($events->speakers());
     */
    public function upsert(Request $request){

        /*if ( auth()->user()->can(['edit event', 'create event']) ){
            return response('Unauthorized', 403);
        }*/

        if (auth()->user()->hasPermissionTo('edit event', 'api') && auth()->user()->hasPermissionTo('create event', 'api') ){
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

    /**
     * Upload a photo
     * 
     * API
     * 
     * @TODO: place this as a helper function
     */
    public function uploadPoster(Request $request){

        /*if ( auth()->user()->can(['edit poster', 'add poster']) ){
            return response('Unauthorized', 403);
        }*/

        if (auth()->user()->hasPermissionTo('edit poster', 'api') && auth()->user()->hasPermissionTo('add poster', 'api') ){
            return response('Unauthorized', 403);
        }

        $validatedData = $request->validate([
            "photo" => "nullable|sometimes|image|mimes:jpeg,bmp,png,jpg|max:2000"
        ]);
        
        // get the max id of the object
        $id = Speaker::max('id');
        // if id is present in the payload, then use it, it means that we are updating an entity
        if ( $request->input('id') )
            $id = $request->input('id');

        $success = $file_path = false;
        // Upload all files
        if ( null != $request->file('photo') ){
            $photo = $request->file('photo');
            $photo_filename  = $photo->getClientOriginalName();
            //$filename = $logo->storeAs('templates' . '/' . $template->id, $photo_filename);
            $file_path = $photo->store("files/$id");
        }
        // to access public files in url http://localhost:8000/files/eclOueMC57PBMVylqzhIiumaoGh72UHZFbEyjiz5.jpeg
        
        $success = $file_path ? true : false;
        return ['success' => $success, 'file_path' => $file_path ];
    }
    /**
     * Frontend display event page
     */
    public function display_event( $URI, $event_id ) {
        
        $theURI = filter_var($URI, FILTER_SANITIZE_STRING);
        $theEventID = filter_var($event_id, FILTER_SANITIZE_NUMBER_INT);
        $department = Department::where('url', $URI)->firstOrFail();

        /*
            1. get the event
            2. check if it is live
            3. if yes, then display
            4. if not, check if the user is the author of the event, the administrator of the department or superadministrator
            5. if yes, display the event
            6. if not throw 404 
        */
        $theEvent = $this->events->findOrFail($theEventID);

        if( $theEvent->is_public && $theEvent->is_approved ){
            $event = $theEvent;
        }
        else {
            if (auth()->check()){
                $auth_user = auth()->user();
                //dd($auth_user->is_super_admin() );
                // check if author of event || administrator of department || super administrator
                if ( ($auth_user->is_event_author($theEvent->created_by)) || 
                    ( $auth_user->is_department_admin($theEvent->department_id) ) ||
                    ( $auth_user->is_super_admin() )
            
                ){
                    $event = $theEvent;
                }
                else {
                    // return not found error
                    abort(404);
                }
            }
            else {
                // return not found error
                abort(404);
            }
        }
        
    
        /// script
        /** @var Organiser $organiser */
        /*$organiser = Organiser::findOrFail($organiser_id);

        if (!$organiser->enable_organiser_page && !Utils::userOwns($organiser)) {
            abort(404);
        }*/

        /*
         * If we are previewing styles from the backend we set them here.
         */
        /*
        if ($request->get('preview_styles') && Auth::check()) {
            $query_string = rawurldecode($request->get('preview_styles'));
            parse_str($query_string, $preview_styles);

            $organiser->page_bg_color = $preview_styles['page_bg_color'];
            $organiser->page_header_bg_color = $preview_styles['page_header_bg_color'];
            $organiser->page_text_color = $preview_styles['page_text_color'];
        }*/
        
        /*
        $data = [
            'department'       => $organiser,
            'tickets'         => $organiser->events()->orderBy('created_at', 'desc')->get(),
            'is_embedded'     => 0,
            'upcoming_events' => $upcoming_events,
            'past_events'     => $past_events,
        ];
        */
        
        /// end script
        // settings
        $settings = Setting::all(['name', 'value']);
        $objSettings = [];

        foreach ($settings as $setting){
            $value = $setting->value;

            if (strpos($setting->name , 'is_') !== false)
                $value = boolval($setting->value);

            $objSettings[$setting->name] = $value;
        }
        
        return view('front.event.homepage', compact(
            'department',
            'event',
            'objSettings',
        ));
    }

    /**
     * for frontend contact form
     */
    public function contact_us(ContactFormRequest $request){
        
        SendEmailFrontendJob::dispatch($request->except(['g_recaptcha_response']))
                ->delay(now()->addSeconds(5)); 

        return ['success' => true, 'message' => config('eppms.messages.frontend_success') ];
       
    }
}