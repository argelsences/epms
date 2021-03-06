<?php

namespace App\Http\Controllers;

use App\Venue;
use App\Country;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.venues.list');
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
     * @param  \App\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function show(Venue $venue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function edit(Venue $venue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venue $venue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venue $venue)
    {
        //
    }
    /**
     * API function
     * 
     * List all departments
     * 
     */
    public function list(Venue $model){
        
        if ( !auth()->user()->can(['list venue']) ){
            return response('Unauthorized', 403);
        }

        /*
        if (!auth()->user()->hasPermissionTo('list venue', 'api') ){
            return response('Unauthorized', 403);
        }
        */

        return response()->json(($model::orderBy('name', 'ASC')->get()));
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
        if ( !auth()->user()->can(['edit venue', 'add venue']) ){
            return response('Unauthorized', 403);
        }

        /*if (!auth()->user()->hasPermissionTo('edit venue', 'api') && auth()->user()->hasPermissionTo('add venue', 'api') ){
            return response('Unauthorized', 403);
        }*/

        $upsertSuccess = false;
        $venue = $request->post('payload');

        if ( $venue['id'] ){
            // retrieve the user object
            $theVenue = Venue::findOrFail($venue['id']);
            // update the user object with updated details
            $theVenue = tap($theVenue)->update($venue);
        }
        else{
            $theVenue = Venue::create($venue);
            $upsertSuccess = ($theVenue->id) ? true : false;
        }
        // return the same data compared to list to ensure using the same 
        $success = ($theVenue) ? true : false;
        return ['success' => $success, 'item' => $theVenue];
    }
    /**
     * API
     * 
     * Get countries
     */
    public function countries(Country $country){

        if ( !auth()->user()->can(['list venue']) ){
            return response('Unauthorized', 403);
        }

        /*if (!auth()->user()->hasPermissionTo('list venue', 'api') ){
            return response('Unauthorized', 403);
        }*/

        return response()->json($country->all('countries'));
    }
}
