<?php

namespace App\Http\Controllers;

use App\Template;
use Illuminate\Http\Request;
use Storage;
use App\Rules\CSSValidator;
use App\Rules\HTMLValidator;
use EPPMS;

class TemplateController extends Controller
{
    protected $templates;

    public function __construct(Template $templates){
        $this->templates = $templates;
    }
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
        
        /*if ( auth()->user()->can(['list template']) ){
            return response('Unauthorized', 403);
        }*/

        if (auth()->user()->hasPermissionTo('list template', 'api') ){
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
            $return = $this->create_by_upload($request);
        }

        if ($request->input('method') == 'code'){
            $return = $this->create_by_code($request);
        }
        
        return $return;
    }

    /**
     * TODO
     * 
     * 12. Poster list and media generation
     * 
     * TODAY (12/10/20)
     * 
     * 1. Allow to download the template files
     * 2. Create guide on how to create template
     * 3. Create a sample templates (3) partial (2)
     * 4. Frontend for each department DONE
     * 5. System setting page DONE
     * 
     * Logic for upload edit
     * 
     */
    /**
    * 1. When html file is present
    *    -- read the existing css file
    *    -- read the existing images
    *    -- build the html again    
    *    2. When css file is present
    *    -- read the existing html file
    *    -- insert the css file to the existing html file
    *    -- read the existing images
    *    -- build the html again
    *
    *    3. When image is present
    *    -- read the existing html file
    *    -- read the existing css file
    *    -- insert the existing css file to html
    *    -- build the html again
    *
    *    4. When html and css is present
    *    -- read the existing image
    *    -- read the new html code
    *    -- read the new css code
    *    -- rebuild the html 
    *
    *    5. when html, css and images are present
    *    -- rebuild all
    *
    * TODAY (09/10/20)
    * 1. Display department name in template list DONE
    * 2. Edit for template code DONE
    * 3. Generate screenshot based on shortcodes DONE
    * %title%
    * %date%
    * %excerpt%
    * %synopsis%
    * %start_date%
    * %end_date%
    * %speakers%
    * %department_name%
    * %event_date%
    * 4. Generate a config file for EPPMS only DONE
    * 5. Create guide on how to create template
    * 6. Frontend for each department
    * 7. System setting page
    * 8. Create a sample templates (3) partial (2)
    * 9. BUG: When no css code for existing templates, edit throws error DONE
     */
    private function create_by_upload(Request $request){

        $html_code = $css_code = "";
        $template_arr  = $file_path_data = [];

        // assign inputs
        $html_file = $request->file('html_code');
        $css_file = $request->file('css_code');

        // get content of the html file, validate only when there is a file present
        // HTML
        if ($request->hasFile('html_code') && $html_file->isValid()) {
            $this->validate($request, ['html_code' => new HTMLValidator]);
            $html_code = $html_file->get();
        }
        else{
            // check if we are updating
            if ($request->input('id')){
                // retrieve the html_code from stored file
                $templateObj = $this->templates->findOrFail($request->input('id'));
                $html_code = Storage::disk('local')->get('templates' . '/' . $templateObj->id . '/' . $templateObj->file_path['html_code'] );
            }
        }
        
        // CSS
        // get content of the css file, validate only when there is a file present
        if ($request->hasFile('css_code') && $css_file->isValid()) {
            $this->validate($request, ['css_code' => new CSSValidator]);
            $css_code = $css_file->get();
            $css_code_inline = "<style scoped>$css_code</style>";
            $html_code = substr_replace($html_code , $css_code_inline, strpos($html_code, '</head>'), 0);
        }
        else{
            if ($request->input('id')){
                $templateObj = $this->templates->findOrFail($request->input('id'));
                $css_code = Storage::disk('local')->get('templates' . '/' . $templateObj->id . '/' . $templateObj->file_path['css_code'] );
                $css_code_inline = "<style scoped>$css_code</style>";
                $html_code = substr_replace($html_code , $css_code_inline, strpos($html_code, '</head>'), 0);
            }
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
        else {
            if ($request->input('id')){
                $templateObj = $this->templates->findOrFail($request->input('id'));
                $images = $templateObj->file_path['images'];
                
                foreach ($images as $image){
                    $image_path = Storage::disk('local')->path('templates' . '/' . $templateObj->id . '/' . $image);
                    $image_extension = pathinfo($image_path, PATHINFO_EXTENSION);
                    $image_content = Storage::disk('local')->get('templates' . '/' . $templateObj->id . '/' . $image );
                    $image_base64 = base64_encode($image_content);
                    $the_image = "data:image/$image_extension;base64,$image_base64";
                    if ( strpos($html_code, $image) ){
                        $html_code = str_replace($image, $the_image, $html_code);
                    }
                }
            }
        }

        /**
         * Check for any new files, then use them, if none, then just use what was in the database and skip other updates. 
         * If there is an ID then it is an update, if none, then it is create
         */
        // encode the template
        $html_code = htmlentities($html_code, ENT_QUOTES, 'UTF-8');
        
        $template_arr = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'template_code' => $html_code, 
            'department_id' => $request->input('department_id'),  
            'method' => $request->input('method'),         
        ];

        //echo html_entity_decode($template['template_code'], ENT_QUOTES, 'UTF-8');

        if ($request->input('id')){
            // retrieve the user object
            $template = $this->templates->findOrFail($request->input('id'));
            // update the user object with updated details
            $template = tap($template)->update($template_arr);
        }
        else {
            // we do not have value for the file paths first, just include an empty string
            $template_arr['file_path'] = '';
            $template = Template::create($template_arr);
            $upsertSuccess = ($template->id) ? true : false;
        }

        // upload the template files here
        // we need the template id to be returned first
        // approach is to remove first the content of the template folder, then reupload the file
        /**
         * TODO: some of the condition here are repetition of what was done on top
         */

        // upload the html file
        $file_path_data = [
            'html_code' => '',
            'css_code'  => '',
            'images'    => [],
            'path'      => '',
        ];
        // can make this inline with code on top?
        if ($request->hasFile('html_code') && $html_file->isValid()) {
            $html_filename = $html_file->getClientOriginalName();
            $html_path = $html_file->storeAs('templates' . '/' . $template->id , $html_filename);
            $file_path_data['html_code'] = $html_filename;
        }
        else{
            // check if we are updating
            if ($request->input('id')){
                // retrieve the html_code from DB
                $file_path_data['html_code'] = $this->templates->findOrFail($request->input('id'))->file_path['html_code'];
            }
        }

        // upload the css file
        if ($request->hasFile('css_code') && $css_file->isValid()) {
            $css_filename = $css_file->getClientOriginalName();
            $css_path = $css_file->storeAs('templates' . '/' . $template->id , $css_filename);
            $file_path_data['css_code'] = $css_filename;
        }
        else{
            // check if we are updating
            if ($request->input('id')){
                // retrieve the html_code from DB
                $file_path_data['css_code'] = $this->templates->findOrFail($request->input('id'))->file_path['css_code'];
            }
        }

        // Upload all images
        if ($request->hasFile('images')) {
            foreach ($images as $image) {
                $image_filename  = $image->getClientOriginalName();
                $image_path = $image->storeAs('templates' . '/' . $template->id, $image_filename);
                $file_path_data['images'][] = $image_filename;
            }
        }
        else{
            // check if we are updating
            if ($request->input('id')){
                // retrieve the html_code from DB
                $templateObj = $this->templates->findOrFail($request->input('id'));
                $images = $templateObj->file_path['images'];
                $file_path_data['images'] = $images;
            }
        }

        // store the path, though virtually this can be assumed as templates/{id}
        $file_path_data['path'] = Storage::disk('local')->path('templates/'.$template->id);

        // serialize the file_path_data
        $serialized_data = serialize($file_path_data);

        // update the file path
        $template->file_path = $serialized_data;
        $template->update();

        // lets generate a thumbnail
        $the_thumbnail = $this->thumbnail($template, true);

        // return the same data compared to list to ensure using the same 
        $success = ($template) ? true : false;
        return ['success' => $success, 'item' => $template];
    }

    /**
     * Code responsible for processing templates based on upload code as selection
     * @TODO: simplify code same with the create_by_upload
     */

    private function create_by_code (Request $request){
        // validate first the files
        $html_code = $css_code = "";
        $template_arr  = $file_path_data = [];

        // assign inputs
        $html_code = $request->input('html_code');
        $css_code = $request->input('css_code');

        // get content of the css file
        if ($request->input('css_code') !== '' || $request->input('css_code') !== null ) {
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
                    $html_code = str_replace($image_filename, $the_image, $html_code);
                }
            }
        }
        else {
            if ($request->input('id')){
                $templateObj = $this->templates->findOrFail($request->input('id'));
                $images = $templateObj->file_path['images'];
                
                foreach ($images as $image){
                    $image_path = Storage::disk('local')->path('templates' . '/' . $templateObj->id . '/' . $image);
                    $image_extension = pathinfo($image_path, PATHINFO_EXTENSION);
                    $image_content = Storage::disk('local')->get('templates' . '/' . $templateObj->id . '/' . $image );
                    $image_base64 = base64_encode($image_content);
                    $the_image = "data:image/$image_extension;base64,$image_base64";
                    if ( strpos($html_code, $image) ){
                        $html_code = str_replace($image, $the_image, $html_code);
                    }
                }
            }
        }

        // encode the template
        $html_code = htmlentities($html_code, ENT_QUOTES, 'UTF-8');
        
        $template_arr = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'template_code' => $html_code, 
            'department_id' => $request->input('department_id'),
            'method' => $request->input('method'),            
        ];

        if ($request->input('id')){
            // retrieve the user object
            $template = $this->templates->findOrFail($request->input('id'));
            // update the user object with updated details
            $template = tap($template)->update($template_arr);
        }
        else {
            // we do not have value for the file paths first, just include an empty string
            $template_arr['file_path'] = '';
            $template = Template::create($template_arr);
            $upsertSuccess = ($template->id) ? true : false;
        }

        // Upload all images
        if ($request->hasFile('images')) {
            foreach ($images as $image) {
                $image_filename  = $image->getClientOriginalName();
                $image_path = $image->storeAs('templates' . '/' . $template->id, $image_filename);
                $file_path_data['images'][] = $image_filename;
            }
        }
        else{
            // check if we are updating
            if ($request->input('id')){
                // retrieve the html_code from DB
                $templateObj = $this->templates->findOrFail($request->input('id'));
                $images = $templateObj->file_path['images'];
                $file_path_data['images'] = $images;
            }
        }

        // store the path, though virtually this can be assumed as templates/{id}
        $file_path_data['path'] = Storage::disk('local')->path('templates/'.$template->id);

        // html code
        $file_path_data['html_code'] = htmlentities($request->input('html_code'), ENT_QUOTES, 'UTF-8');

        // css code
        $file_path_data['css_code'] = htmlentities($request->input('css_code'), ENT_QUOTES, 'UTF-8');

        // serialize the file_path_data
        $serialized_data = serialize($file_path_data);

        // update the file path
        $template->file_path = $serialized_data;
        $template->update();        

        // lets generate a thumbnail
        $the_thumbnail = $this->thumbnail($template, true);

        // return the same data compared to list to ensure using the same 
        $success = ($template) ? true : false;
        return ['success' => $success, 'item' => $template];
    }

    private function thumbnail(Template $template, $preview = false){
        return EPPMS::thumbnail($template, $preview);
    }

    public function screenshot($id){
        $template = $this->templates->findOrFail($id);
        
        return EPPMS::getScreenshot($template->file_path['path']);
    }
}