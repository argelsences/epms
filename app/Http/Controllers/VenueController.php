<?php

namespace App\Http\Controllers;

use App\Venue;
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
        return view('admin.departments.list');
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
        
        if ( auth()->user()->can(['list venue']) ){
            return response('Unauthorized', 403);
        }

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
    public function upsert(DepartmentRequest $request)
    {
        if ( auth()->user()->can(['edit department', 'add department']) ){
            return response('Unauthorized', 403);
        }

        $upsertSuccess = false;
        $department = $request->post('payload');

        if ( $department['id'] ){
            // retrieve the user object
            $theDepartment = Department::findOrFail($department['id']);
            // update the user object with updated details
            $theDepartment = tap($theDepartment)->update($department);
            //$department['updated_at'] = Carbon::now(env("APP_TIMEZONE"));
        }
        else{
            $theDepartment = Department::create($department);
            $upsertSuccess = ($theDepartment->id) ? true : false;
        }
        // return the same data compared to list to ensure using the same 
        $success = ($theDepartment) ? true : false;
        return ['success' => $success, 'item' => $theDepartment];
    }
}
