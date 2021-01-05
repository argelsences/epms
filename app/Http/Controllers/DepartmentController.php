<?php

namespace App\Http\Controllers;

use App\Department;
use App\Setting;
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
     * 
     * List all departments
     * 
     */
    public function list(Department $model){
        
        /*if ( auth()->user()->can(['list department']) ){
            return response('Unauthorized', 403);
        }*/
        
        if (auth()->user()->hasPermissionTo('list department', 'api') ){
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
        /*if ( auth()->user()->can(['edit department', 'add department']) ){
            return response('Unauthorized', 403);
        }*/

        if (auth()->user()->hasPermissionTo('edit department', 'api') && auth()->user()->hasPermissionTo('add department', 'api') ){
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
    /**
     * Upload a logo
     * 
     * API
     * 
     * @TODO: place this as a helper function
     */
    public function uploadLogo(Request $request){

        /*if ( auth()->user()->can(['edit department', 'add department']) ){
            return response('Unauthorized', 403);
        }*/
        
        if (auth()->user()->hasPermissionTo('edit department', 'api') && auth()->user()->hasPermissionTo('add department', 'api') ){
            return response('Unauthorized', 403);
        }

        $validatedData = $request->validate([
            "logo" => "nullable|sometimes|image|mimes:jpeg,bmp,png,jpg|max:2000"
        ]);
        
        // get the max id of the object
        $id = Department::max('id');
        // if id is present in the payload, then use it, it means that we are updating an entity
        if ( $request->input('id') )
            $id = $request->input('id');

        $success = $file_path = false;
        // Upload all files
        if ( null != $request->file('logo') ){
            $logo = $request->file('logo');
            $logo_filename  = $logo->getClientOriginalName();
            //$filename = $logo->storeAs('templates' . '/' . $template->id, $photo_filename);
            $file_path = $logo->store("files/$id");
        }
        // to access public files in url http://localhost:8000/files/eclOueMC57PBMVylqzhIiumaoGh72UHZFbEyjiz5.jpeg
        
        $success = $file_path ? true : false;
        return ['success' => $success, 'file_path' => $file_path ];
    }
    /**
     * Frontend department homepage
     */
    public function homepage( $URI ){
        $theURI = filter_var($URI, FILTER_SANITIZE_STRING);
        $department = Department::where('url', $URI)->firstOrFail();
    
        $upcoming_events = $department->events()->where('end_date', '>=', now())
            ->live()
            ->orderBy('start_date', 'DESC')
            ->get();

        $past_events = $department->events()->where( 'end_date', '<', now() )
            ->live()
            ->orderBy('start_date', 'DESC')
            ->limit(10)
            ->get();
        
        // settings
        $settings = Setting::all(['name', 'value']);
        $objSettings = [];

        foreach ($settings as $setting){
            $value = $setting->value;

            if (strpos($setting->name , 'is_') !== false)
                $value = boolval($setting->value);

            $objSettings[$setting->name] = $value;
        }
        
        return view('front.department.homepage', compact(
            'department',
            'upcoming_events',
            'past_events',
            'objSettings',
        ));
    }

    public function front_list(Department $model){
        
        $department_event = [];
        $x = 0;

        $departments = $model::orderBy('name', 'ASC')->get(['id','name','logo_path','page_header_bg_color','url']);

        foreach ( $departments as $department ) {
            $department_event[$x]['department'] = $department;
            $department_event[$x]['events'] = $department->events()->where([
                                                ['end_date', '>=', now()],
                                                ['is_public', 1],
                                                ['is_approved', 1]
                                            ])->get(['id','title','start_date']);
            $department_event[$x]['events']['count'] = count($department_event[$x]['events']);
            
            $x++;
        }
        
        return response()->json($department_event);

    }
}
