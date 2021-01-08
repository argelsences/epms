<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Country;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settings;

    public function __construct(Setting $settings){
        $this->settings = $settings;
    }
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
     * List all settings
     * 
     */
    public function list(Setting $model){
        
        if ( !auth()->user()->can(['edit settings']) ){
            return response('Unauthorized', 403);
        }
        /*
        if (auth()->user()->hasPermissionTo('edit settings', 'api') ){
            return response('Unauthorized', 403);
        }
        */
        // assign values here manually
        $settings = $model::all(['name', 'value']);
        $objSettings = [];

        foreach ($settings as $setting){
            $value = $setting->value;

            if (strpos($setting->name , 'is_') !== false)
                $value = boolval($setting->value);

            $objSettings[$setting->name] = $value;
        }

        return response()->json($objSettings);
    }
    /**
     * Retrieve list of timezones
     */
    public function timezones(Country $country){
        if ( !auth()->user()->can(['edit settings']) ){
            return response('Unauthorized', 403);
        }

        /*if (auth()->user()->hasPermissionTo('edit settings', 'api') ){
            return response('Unauthorized', 403);
        }*/

        return response()->json($country->timezones());
    }
    /**
     * Save settings
     */
    public function upsert(Request $request)
    {
        if ( !auth()->user()->can(['edit settings']) ){
            return response('Unauthorized', 403);
        }

        /*if (auth()->user()->hasPermissionTo('edit settings', 'api') ){
            return response('Unauthorized', 403);
        }*/

        $objSettings = $request->post('payload');

        foreach ($objSettings as $key => $value){
            $the_setting = $this->settings->where('name', $key);
            $the_setting->update([
                'value' => $value,
            ]);
        }

        // assign values here manually
        $settings = $this->settings->all(['name', 'value']);
        $objSettings = [];

        foreach ($settings as $setting){
            $value = $setting->value;

            if (strpos($setting->name , 'is_') !== false)
                $value = boolval($setting->value);

            $objSettings[$setting->name] = $value;
        }

        return ['success' => true, 'item' => $objSettings];
    }

}
