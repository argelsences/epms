<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.templates.list');
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
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Template $template)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        //
    }
    /**
     * Additional component paths
     */
    /**
     * For template creation choices
     */
    public function template_choice() {
        //
        return view('admin.templates.template_choice');
    }
    /**
     * For creating templates by uploading
     */
    public function by_upload() {
        //
        return view('admin.templates.by_upload');
    }
    /** 
     * For creating templates by code
     */
    public function by_code() {
        //
        return view('admin.templates.by_code');
    }
    /** 
     * For creating templates by canvas
     */
    public function by_canvas() {
        //
        return view('admin.templates.by_canvas');
    }
    /**
     * API function
     * 
     * List all departments
     * 
     */
    public function list(Template $model){
        
        if ( auth()->user()->can(['list template']) ){
            return response('Unauthorized', 403);
        }

        return response()->json(($model::orderBy('name', 'ASC')->get()));
    }
}
