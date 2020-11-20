<?php

namespace App\Helpers;

use App\Template;
use Spatie\Browsershot\Browsershot;
use Storage;
use Image;
use Illuminate\Support\Facades\Auth;

class EPPMSHelper {

    public function thumbnail(Template $template, $preview = false){
        
        $file_path = $template->file_path;
        $the_template = html_entity_decode($template->template_code, ENT_QUOTES, 'UTF-8');

        // if not preview, then process the the_template from event
        // if yes, then process for preview (basically nothing to do)
        if ($preview) {
            $the_template = $this->parser($the_template, $preview);
        }
        else {
            
        }

        Browsershot::html($the_template)
                /////->setOption('addStyleTag',json_encode(['content' => $the_css_code]))
                ->noSandbox()
                ->setScreenshotType('jpeg', 100)
                ->disableJavascript()
                ->windowSize(595, 842)
                /////->windowSize(600, 782)
                /////->select('.poster')
                /////->setNodeBinary('/usr/bin/node')
                /////->setNpmBinary('/usr/bin/npm')
                /////->setIncludePath('$PATH:/usr/bin')
                ->setDelay(1000)
                ->waitUntilNetworkIdle()
                ->save(Storage::disk('local')->path('templates/'.$template->id. '/' .'screenshot.jpg' ));

        return true;
    }

    /**
     * Restrict access to screenshots and only allow for logged in users
     */
    public function getScreenshot($path){

        $storage_path = $path . '/screenshot.jpg';

        if (file_exists($storage_path)) {
            return response()->file($storage_path, array('Content-Type' =>'image/jpeg'));
        }

        abort(404);

    }

    /**
     * Process shortcodes from the template
     * %title%
    * %date%
    * %excerpt%
    * %synopsis%
    * %start_date%
    * %end_date%
    * %speakers%
    *   %speaker_name%
    *   %speaker_profile%
    * %/speakers%
    * %venue_name%
    * %venue_address%
    * for texts that may grow longer, add a way to indicate the limit in the shortcode in the template, eg synopsis|limit:150 means for 
    * synopsis, our limite is only 150 characters
     */
    private function parser($template_code = false, $preview = false) {
        if (!$template_code)
            return false;

        preg_match_all("^\[(.*?)\]^",$template_code,$fields, PREG_PATTERN_ORDER);
        preg_match_all("^\[/(.*?)\]^",$template_code,$close_fields, PREG_PATTERN_ORDER);

        if ( $preview ){
            foreach ( $fields[1] as $field ) {
                $the_field = explode(' ', $field);
                if ( in_array( $the_field[0],$this->shortcode_list() )){
                    // set content from default config, if applicable
                    $the_field_text = config("eppms.templates.default.$the_field[0]");
                    // check if we have a parameter for the shortcode
                    if (count( $the_field ) > 1 ) {
                        // we only have 1 parameters supported, which is limit
                        if (preg_match_all('/\s*([^=]+)=(\S+)\s*/', $the_field[1], $params)) {
                            $the_params = array_combine ( $params[1], $params[2] ); 
                            if ( current(array_keys($the_params)) == 'limit' ){
                                $the_field_text = substr( config("eppms.templates.default.$the_field[0]"), 0, $the_params['limit'] );
                                // replace value foro shortcode with params
                                $template_code = str_replace("[$field]", $the_field_text, $template_code); 
                            }
                            
                        }
                            
                    }
                    // replace shortcodes without parameters
                    $template_code = str_replace("[$the_field[0]]", $the_field_text, $template_code);       
                }
            }
        }
        else {
            
        }

        // remove all close shortcodes
        foreach ($close_fields[0] as $close_field){
            $template_code = str_replace($close_field, '', $template_code);
        }

        return $template_code;
        
    }

    private function shortcode_list(){
        return $shortcodes = [
            'title', 'date', 'excerpt', 'synopsis', 'start_date',
            'end_date', 'speakers', 'speaker_name', 'speaker_profile',
            'venue_name', 'venue_address', 'department_name','event_date'
        ];
    }

    /**
     * Set authorship for an event
     */
    public function setEventAuthorship( $event ){
        
        $user_id = Auth::id();
        // if there is an event id, then we will set the edited by to the logged in user
        
        // if no event id, then we set the created by and edited by
        if ($event['id']){
            $event['edited_by'] = Auth::id();
        }
        else {
            $event['created_by'] = $user_id;
            $event['edited_by'] = Auth::id();
        }
        
        return $event;
    }

    /**
     * Set authorship for an event
     */
    public function setAuthorship( $object ){
        
        $user_id = Auth::id();
        // if there is an event id, then we will set the edited by to the logged in user
        
        // if no event id, then we set the created by and edited by
        if ($object['id']){
            $object['edited_by'] = Auth::id();
        }
        else {
            $object['created_by'] = $user_id;
            $object['edited_by'] = Auth::id();
        }
        
        return $object;
    }
}
