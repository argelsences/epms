<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\DepartmentRequest;


class DepartmentController extends Controller
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
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
    }
    /**
     * API function
     */
    public function list(Department $model){
        return response()->json(($model::orderBy('name', 'ASC')->get()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upsert(Request $request)
    {
        if ( auth()->user()->can(['edit department', 'add department']) ){
            return response('Unauthorized', 403);
        }

        $createSuccess = $updateSuccess = false;
        $department = $request->post('payload');
        //dd($request->all());

        //$photo_filename  = $photo->getClientOriginalName();
        //$filename = $photo->storeAs('templates' . '/' . $template->id, $photo_filename);
        /////dd($department);
        
        if ( $department['id'] ){
            // retrieve the user object
            $theDepartment = Department::findOrFail($department['id']);
            // update the user object with updated details
            $updateSuccess = $theDepartment->update($department);
            //$department['updated_at'] = Carbon::now(env("APP_TIMEZONE"));
        }
        else{
            $createSuccess = Department::create($department);
        }
        
        // return the same data compared to list to ensure using the same 
        $success = ($createSuccess || $updateSuccess) ? true : false;
        return ['success' => $success,];
    }

    public function uploadLogo(Request $request){

        // get the id too?
        // do not use original filename
        $success = $filename = $update_logo = true;
        /////dd($request->file);
        // Upload all files
        if ( null != $request->file('logo') ){
            //foreach ($request->file('logo') as $logo) {
                $logo = $request->file('logo');
                //dd($logo);
                $logo_filename  = $logo->getClientOriginalName();
                //dd($logo_filename);
                //$filename = $logo->storeAs('templates' . '/' . $template->id, $photo_filename);
                /////$filename = $logo->storeAs('files' , $logo_filename);
                $filename = $logo->store('files');
                // specify location
                // $filename = $logo->store('files', 'local');
                //$file_path_data = $filename;
            //}
        }
        else {
            $update_logo = false;
        }
        // to access public files in url http://localhost:8000/files/eclOueMC57PBMVylqzhIiumaoGh72UHZFbEyjiz5.jpeg
        
        $success = null != $filename || null == $request->file('logo')? true : false;
        return ['success' => $success, 'file_path' => $filename, 'update_logo' => $update_logo ];
    }
}
