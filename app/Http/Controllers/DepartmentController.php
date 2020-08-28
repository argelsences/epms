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

        $upsertSuccess = false;
        $department = $request->post('payload');

        //$photo_filename  = $photo->getClientOriginalName();
        //$filename = $photo->storeAs('templates' . '/' . $template->id, $photo_filename);
        /* 
        array:16 [
            "id" => 52
            "name" => "aaaaaaas"
            "email" => "a@b.com"
            "phone" => "123456789"
            "facebook" => "https://www.facebook.com"
            "instagram" => "https://instagram.com"
            "logo_path" => "files/Cm7R2GOQMuK10reIJxYoPwqAfMH5DtcfVV7DW41Y.jpeg"
            "page_header_bg_color" => "#033049"
            "page_bg_color" => "#CDCDCD"
            "page_text_color" => "#0E0009"
            "google_analytics_code" => "gac"
            "google_tag_manager_code" => "gtmc"
            "url" => "sdfsdf"
            "created_at" => "2020-08-23T11:05:44.000000Z"
            "updated_at" => "2020-08-28T07:21:37.000000Z"
            "deleted_at" => null
        ]
        */
        /////dd($department);
        
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
        //dd($theDepartment->id);
        // return the same data compared to list to ensure using the same 
        $success = ($upsertSuccess) ? true : false;
        return ['success' => $success, 'item' => $theDepartment];
    }
    /**
     * Upload a logo
     * @TODO: place this as a helper function
     */
    public function uploadLogo(Request $request){

        // get the id too?
        // do not use original filename
        $success = $file_path = false;
        //dd($request->all());
        /////$department = Department::findOrFail($request->input('id'));
        // Upload all files
        if ( null != $request->file('logo') ){
            //foreach ($request->file('logo') as $logo) {
                $logo = $request->file('logo');
                //dd($logo);
                $logo_filename  = $logo->getClientOriginalName();
                //dd($logo_filename);
                //$filename = $logo->storeAs('templates' . '/' . $template->id, $photo_filename);
                /////$filename = $logo->storeAs('files' , $logo_filename);
                $file_path = $logo->store('files');
                // specify location
                // $filename = $logo->store('files', 'local');
                //$file_path_data = $filename;
                /*
                $department->update([
                    'logo_path' => $file_path,
                ]);
                */
            //}
        }
        /*else {
            $file_path = $department->logo_path;
        }*/
        // to access public files in url http://localhost:8000/files/eclOueMC57PBMVylqzhIiumaoGh72UHZFbEyjiz5.jpeg
        
        $success = $file_path ? true : false;
        return ['success' => $success, 'file_path' => $file_path ];
    }
}
