<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Http\Request;
use Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
    /**
     * Saving codes from template choice of upload
     */
    public function upsert(Request $request) {

        if ( auth()->user()->can(['edit template', 'add template']) ){
            return response('Unauthorized', 403);
        }

        if ($request->input('method') == 'upload'){
            $this->create_by_upload($request);
        }
        
        
    }

    /**
     * TODO
     * 1. check the HTML for any javascript tags, if found throw an error and do not proceed
     * 2. Make sure correct files are uploaded
     */
    private function create_by_upload(Request $request){
        
        $html_code = $css_code = "";
        $template = [];

        // get content of the html file
        if ($request->hasFile('html_code') && $request->file('html_code')->isValid()) {
            $html_code = $request->file('html_code')->get();
        }
        // get content of the css file
        if ($request->hasFile('css_code') && $request->file('css_code')->isValid()) {
            $css_code = $request->file('css_code')->get();
            $css_code_inline = "<style scoped>$css_code</style>";
            $html_code = substr_replace($html_code , $css_code_inline, strpos($html_code, '</head>'), 0);
        }

        // process images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            
            foreach ($images as $image){
                // get image filename, this will be used later to match it in the html_code
                $image_filename  = $image->getClientOriginalName();
                // get the image and convert them to base64 equivalent
                $image_content = $image->get();
                $image_base64 = base64_encode($image_content);
                $image_extension = $image->extension();
                $the_image = "data:image/$image_extension;base64,$image_base64";
                if ( strpos($html_code, $image_filename) ){
                    //$html_code = substr_replace($html_code , $the_image, strpos($html_code, $image_filename), 0);
                    $html_code = str_replace($image_filename, $the_image, $html_code);
                }
            }
            
        }
        // encode the template
        $html_code = htmlentities($html_code, ENT_QUOTES, 'UTF-8');
        
        $template = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'file_path' => '',
            'template_code' => $html_code, 
            'department_id' => 1,           
        ];

        //echo html_entity_decode($template['template_code'], ENT_QUOTES, 'UTF-8');

        if ($request->input('id')){
            // retrieve the user object
            $theTemplate = Template::findOrFail($request->input('id'));
            // update the user object with updated details
            $theTemplate = tap($theTemplate)->update($template);
        }
        else {
            $theTemplate = Template::create($template);
            $upsertSuccess = ($theTemplate->id) ? true : false;
        }

        // return the same data compared to list to ensure using the same 
        $success = ($theTemplate) ? true : false;
        return ['success' => $success, 'item' => $theTemplate];
    }
}