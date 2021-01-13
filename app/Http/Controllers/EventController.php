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
use Validator;

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
        
        if ( !auth()->user()->can(['list event']) ){
            return response('Unauthorized', 403);
        }
        /*
        if (!auth()->user()->hasPermissionTo('list event', 'api') ){
            return response('Unauthorized', 403);
        }
        */

        if (auth()->user()->is_super_admin('api')){
            $events = $model::with(['venue','speakers','tickets'])->orderBy('start_date', 'DESC')->get();
        }
        else {
            $events = $model::with(['venue','speakers','tickets'])->filterByDepartment()->orderBy('start_date', 'DESC')->get();
        }

        return response()->json($events);
    }
    /**
     * API Update and Insertdd($events->speakers());
     */
    public function upsert(Request $request){

        if ( !auth()->user()->can(['edit event', 'add event']) ){
            return response('Unauthorized', 403);
        }

        /*if (auth()->user()->hasPermissionTo('edit event', 'api') && auth()->user()->hasPermissionTo('create event', 'api') ){
            return response('Unauthorized', 403);
        }*/

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
            // sync speakers to event
            $theEvent->speakers()->sync( $event['speakers'] );

            $theEvent = $theEvent->fresh();

            $theEvent = Event::with(['venue','speakers'])->find($theEvent->id);

            $upsertSuccess = ($theEvent->id) ? true : false;
        }

        $theEventObj = Event::with(['venue','speakers','tickets'])->findOrFail($theEvent->id);

        // return the same data compared to list to ensure using the same 
        $success = ($theEvent) ? true : false;
        return ['success' => $success, 'item' => $theEventObj];
    }

    /**
     * Upload a photo
     * 
     * API
     * 
     * @TODO: place this as a helper function
     */
    public function uploadPoster(Request $request){

        if ( !auth()->user()->can(['edit poster', 'add poster']) ){
            return response('Unauthorized', 403);
        }

        /*if (auth()->user()->hasPermissionTo('edit poster', 'api') && auth()->user()->hasPermissionTo('add poster', 'api') ){
            return response('Unauthorized', 403);
        }*/

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

        $theEvent = $this->events->findOrFail($theEventID);

        if( $theEvent->is_public && $theEvent->is_approved ){
            $event = $theEvent;
        }
        else {
            if (auth()->check()){
                $auth_user = auth()->user();
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
    public function contact_us(Request $request){

        $validate = Validator::make($request->all(), [
            'g_recaptcha_response' => 'required|captcha',
            'name' => 'required|alpha_dash|max:80',
            'email' => 'required|email',
            'message' => 'required|alpha_dash|max:255',
        ]);
        
        SendEmailFrontendJob::dispatch($request->except(['g_recaptcha_response']))
                ->delay(now()->addSeconds(5)); 

        return ['success' => true, 'message' => config('eppms.messages.frontend_success') ];
       
    }
    /**
     * API function
     * 
     * List all departments
     * 
     */
    public function latest_events(Event $model){
        
        $events = $model::with(['venue','speakers', 'department','poster'])->orderBy('start_date', 'DESC')->take(5)->get();

        return response()->json($events);
    }

    /**
     * API function
     * 
     * List all events with department
     * 
     */
    public function list_with_department(Event $model){
        
        if ( !auth()->user()->can(['list event']) ){
            return response('Unauthorized', 403);
        }
        /*
        if (!auth()->user()->hasPermissionTo('list event', 'api') ){
            return response('Unauthorized', 403);
        }
        */

        if (auth()->user()->is_super_admin('api')){
            $events = $model::with(['venue','department'])->orderBy('start_date', 'DESC')->get();
        }
        else {
            $events = $model::with(['venue','department'])->filterByDepartment()->orderBy('start_date', 'DESC')->get();
        }

        return response()->json($events);
    }

    /**
     * API function
     * Description: function to retrieve events based on range
     */
    public function list_by_range($min, $max){

        if ( !auth()->user()->can(['list event']) ){
            return response('Unauthorized', 403);
        }

        if (auth()->user()->is_super_admin('api')){
            $events = Event::with(['venue','department'])->where([
                ['start_date', '>=', $min],
                ['end_date', '<=', $max]
            ])->orderBy('start_date', 'DESC')->get();
        }
        else {
            $events = Event::with(['venue','department'])->filterByDepartment()->where([
                ['start_date', '>=', $min],
                ['end_date', '<=', $max]
            ])->orderBy('start_date', 'DESC')->get();
        }

        return response()->json($events);
    }
}