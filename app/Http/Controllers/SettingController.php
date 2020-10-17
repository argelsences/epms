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
    /**
     * TODAY: 14 10 2020
     * 1. Create a seeder for settings DONE
     * 2. Load values to edit and to template (use boolval to evaluate values with "is" fields) DONE
     * 3. Allow to save and update the values DONE
     * 4. Fonts to resize based on the parent container (templates)
     * 5. Configure list of timezones (DONE)
     * TODAY: 15 10 2020 
     * 1. Allow to save and update the values (backlog) DONE
     * 2. Fonts to resize based on the parent container (templates) (backlog) DONE
     * 3. Create homepage
     * 4. Create frontpage for each department
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
        
        if ( auth()->user()->can(['edit settings']) ){
            return response('Unauthorized', 403);
        }
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
        if ( auth()->user()->can(['edit settings']) ){
            return response('Unauthorized', 403);
        }

        return response()->json($country->timezones());
    }
    /**
     * Save settings
     */
    public function upsert(Request $request)
    {
        if ( auth()->user()->can(['edit settings']) ){
            return response('Unauthorized', 403);
        }
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
