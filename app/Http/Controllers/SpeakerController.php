<?php

namespace App\Http\Controllers;

use App\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.speakers.list');
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
     * @param  \App\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function show(Speaker $speaker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function edit(Speaker $speaker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Speaker $speaker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Speaker $speaker)
    {
        //
    }

    /**
     * API function
     * 
     * List all speakers
     * 
     */
    public function list(Speaker $model){
        if ( !auth()->user()->can(['list speaker']) ){
            return response('Unauthorized', 403);
        }

        /*if (!auth()->user()->hasPermissionTo('list speaker', 'api') ){
            return response('Unauthorized', 403);
        }*/
        if (auth()->user()->is_super_admin('api')){
            $speakers = $model::orderBy('name', 'ASC')->get();
        }
        else {
            $speakers = $model::filterByDepartment()->orderBy('name', 'ASC')->get();
        }

        return response()->json($speakers);
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
        if ( !auth()->user()->can(['edit speaker', 'add speaker']) ){
            return response('Unauthorized', 403);
        }

        /*if (auth()->user()->hasPermissionTo('edit speaker', 'api') && auth()->user()->hasPermissionTo('add speaker', 'api') ){
            return response('Unauthorized', 403);
        }*/

        $upsertSuccess = false;
        $speaker = $request->post('payload');

        if ( $speaker['id'] ){
            // retrieve the user object
            $theSpeaker = Speaker::findOrFail($speaker['id']);
            // update the user object with updated details
            $theSpeaker = tap($theSpeaker)->update($speaker);
            //$department['updated_at'] = Carbon::now(env("APP_TIMEZONE"));
        }
        else{
            $theSpeaker = Speaker::create($speaker);
            $upsertSuccess = ($theSpeaker->id) ? true : false;
        }
        // return the same data compared to list to ensure using the same 
        $success = ($theSpeaker) ? true : false;
        return ['success' => $success, 'item' => $theSpeaker];
    }
    /**
     * Upload a photo
     * 
     * API
     * 
     * @TODO: place this as a helper function
     */
    public function uploadPhoto(Request $request){

        if ( !auth()->user()->can(['edit speaker', 'add speaker']) ){
            return response('Unauthorized', 403);
        }

        /*if (auth()->user()->hasPermissionTo('edit speaker', 'api') && auth()->user()->hasPermissionTo('add speaker', 'api') ){
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
     * API
     * Description: return speakers by department
     */
    public function list_by_department($department_id){
        
        if ( !auth()->user()->can(['list speaker']) ){
            return response('Unauthorized', 403);
        }

        $speakers = Speaker::where('department_id', $department_id)->orderBy('name', 'ASC')->get();

        return response()->json($speakers);
    }
}
