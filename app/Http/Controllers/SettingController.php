<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
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
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    /**
     * TODAY: 14 10 2020
     * 1. Create a seeder for settings DONE
     * 2. Load values to edit and to template (use boolval to evaluate values with "is" fields)
     * 3. Allow to save and update the values
     * 4. Fonts to resize based on the parent container (templates)
     */
    public function edit(Setting $setting)
    {
        //
        return view('admin.settings.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
    /**
     * API function
     * 
     * List all departments
     * 
     */
    public function list(Setting $model){
        
        if ( auth()->user()->can(['edit settings']) ){
            return response('Unauthorized', 403);
        }
        dd($model::orderBy('name', 'ASC')->get());
        return response()->json(($model::orderBy('name', 'ASC')->get()));
    }
}
