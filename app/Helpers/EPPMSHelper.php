<?php

namespace App\Helpers;

use App\Template;
use Spatie\Browsershot\Browsershot;
use Storage;
use Image;

class EPPMSHelper {

    public function thumbnail(Template $template, $preview = true){
        
        $file_path = $template->file_path;
        $the_template = html_entity_decode($template->template_code, ENT_QUOTES, 'UTF-8');

        // if not preview, then process the the_template from event
        // if yes, then process for preview (basically nothing to do)

        Browsershot::html($the_template)
                /////->setOption('addStyleTag',json_encode(['content' => $the_css_code]))
                ->noSandbox()
                ->setScreenshotType('jpeg', 100)
                ->disableJavascript()
                ////////->windowSize(595, 842)
                ->windowSize(600, 782)
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
     */
    private function shortcodes($template_code = false) {
        if (!$template_code)
            return false
    }
}
