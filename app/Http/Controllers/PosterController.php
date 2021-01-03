<?php

namespace App\Http\Controllers;

use App\Poster;
use App\Template;
use App\Event;
use Illuminate\Http\Request;
use EPPMS;

class PosterController extends Controller
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
     * @param  \App\Poster  $poster
     * @return \Illuminate\Http\Response
     */
    public function show(Poster $poster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Poster  $poster
     * @return \Illuminate\Http\Response
     */
    public function edit(Poster $poster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Poster  $poster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Poster $poster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Poster  $poster
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poster $poster)
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
        /*if ( auth()->user()->can(['view poster']) ){
            return response('Unauthorized', 403);
        }*/

        if (auth()->user()->hasPermissionTo('view poster', 'api') ){
            return response('Unauthorized', 403);
        }

        $thePoster = Poster::where('event_id', $event)->first();
        
        return response()->json(($thePoster));
    }
    /**
     * API Function
     * Upload a poster for an event
     */
    /**
     * Upload a photo
     * 
     * API
     * 
     * @TODO: place this as a helper function
     */
    public function upload(Request $request){

        /*if ( auth()->user()->can(['edit speaker', 'add speaker']) ){
            return response('Unauthorized', 403);
        }*/

        if (auth()->user()->hasPermissionTo('edit poster', 'api') && auth()->user()->hasPermissionTo('add poster', 'api') ){
            return response('Unauthorized', 403);
        }

        $validatedData = $request->validate([
            "photo" => "nullable|sometimes|image|mimes:jpeg,bmp,png,jpg|max:2000"
        ]);

        $params = $thePoster = [];

        if ( $request->input('id') )
            $id = $request->input('id');

        if (null != $request->file('poster') )
            $photo = $request->file('poster');


        if ( $id && $photo ){
            $params = [
                'id' => $id,
                'photo' => $photo,
            ];

            $thePoster = EPPMS::uploadPoster($params);
            $generateSuccess = ($thePoster->id) ? true : false;
        }
        // to access public files in url http://localhost:8000/files/eclOueMC57PBMVylqzhIiumaoGh72UHZFbEyjiz5.jpeg
        
        $success = ($thePoster) ? true : false;
        return ['success' => $success, 'item' => $thePoster];
    }

    /**
     * API Function
     * Remove an image file from poster
     */
    public function deleteFile(Poster $poster) {

        if (auth()->user()->hasPermissionTo('edit poster', 'api') && auth()->user()->hasPermissionTo('add poster', 'api') ){
            return response('Unauthorized', 403);
        }

        $removeFile = $poster->update(['file_path' => '']);  
        
        $success = ($removeFile) ? true : false;
        return ['success' => $success, 'item' => $poster];
    }

    /**
     * Generate poster
     */
    public function generate(Request $request){
        
        $template = Template::findOrFail($request->post('template_id'));
        $event = Event::findOrFail($request->post('event_id'));
        // fix later to allow event embed or better yet create another function
        $generatePosters = EPPMS::generatePoster($template, $event);
        $success = $generatePosters;
        // return poster object
        $poster = Event::findOrFail($event->id)->poster;

        return ['success' => $success, 'item' => $poster];
    }

}
