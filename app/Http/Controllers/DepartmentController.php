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
            $upsertSuccess = $theDepartment->update($department);
            //$department['updated_at'] = Carbon::now(env("APP_TIMEZONE"));
        }
        else{
            $theDepartment = Department::create($department);
            $upsertSuccess = ($theDepartment->id) ? true : false;
        }
        // return the same data compared to list to ensure using the same 
        $success = ($upsertSuccess) ? true : false;
        return ['success' => $success, 'item' => $theDepartment];
    }
    /**
     * Upload a logo
     * @TODO: place this as a helper function
     */
    public function uploadLogo(Request $request){

        $validatedData = $request->validate([
            "logo" => "nullable|sometimes|image|mimes:jpeg,bmp,png,jpg|max:2000"
        ]);
        
        $success = $file_path = false;
        // Upload all files
        if ( null != $request->file('logo') ){
            $logo = $request->file('logo');
            $logo_filename  = $logo->getClientOriginalName();
            //$filename = $logo->storeAs('templates' . '/' . $template->id, $photo_filename);
            $file_path = $logo->store('files/tmp');
        }
        // to access public files in url http://localhost:8000/files/eclOueMC57PBMVylqzhIiumaoGh72UHZFbEyjiz5.jpeg
        
        $success = $file_path ? true : false;
        return ['success' => $success, 'file_path' => $file_path ];
    }
}
