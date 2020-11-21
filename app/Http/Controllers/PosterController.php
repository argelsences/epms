<?php

namespace App\Http\Controllers;

use App\Poster;
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

        if ( auth()->user()->can(['edit speaker', 'add speaker']) ){
            return response('Unauthorized', 403);
        }

        $validatedData = $request->validate([
            "photo" => "nullable|sometimes|image|mimes:jpeg,bmp,png,jpg|max:2000"
        ]);
        
        // get the max id of the object
        /////$id = Speaker::max('id');
        // if id is present in the payload, then use it, it means that we are updating an entity

        $params = [];

        if ( $request->input('id') )
            $id = $request->input('id');

        if (null != $request->file('poster') )
            $photo = $request->file('poster');


        if ( $id && $photo ){
            $params = [
                'id' => $id,
                'photo' => $photo,
            ];

            $thePoster = EPPMS::generatePoster($params);
        }

        $success = $file_path = false;

        // Upload all files
        //if ( null != $request->file('poster') ){


            /*
            $photo = $request->file('poster');
            $photo_filename  = $photo->getClientOriginalName();
            $file_path = $photo->storeAs("files/events/poster/$id", $photo_filename);
            */
            //$file_path = $photo->store("files/events/poster/$id");

            // create a poster object and used the file_path
            // for upload, the file_path will be used
            // if file path is used, clear the poster code value
            // if template is used for the template, then clear the file_path content
            // for each generation of new poster, the old poster files should be cleared
        //}
        // to access public files in url http://localhost:8000/files/eclOueMC57PBMVylqzhIiumaoGh72UHZFbEyjiz5.jpeg
        
        $success = $file_path ? true : false;
        return ['success' => $success, 'file_path' => $file_path ];
    }
}
