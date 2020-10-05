<?php

namespace App\Helpers;

use App\Template;
use Spatie\Browsershot\Browsershot;
use Storage;
use Image;

class EPPMSHelper {

    public function thumbnail(Template $template){
        
        $file_path = $template->file_path;
        $the_template = html_entity_decode($template->template_code, ENT_QUOTES, 'UTF-8');

        Browsershot::html($the_template)
                /////->setOption('addStyleTag',json_encode(['content' => $the_css_code]))
                ->noSandbox()
                ->setScreenshotType('jpeg', 100)
                ->disableJavascript()
                ->windowSize(595, 842)
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

        //$template = Template::findOrFail($id);
        //$file_path = $template->file_path;
        //$storagePath = Storage::disk('local')->path($path. '/' .'screenshot.jpg');
        //dd($path);
        //$the_image = base64_decode($path);
        //dd($the_image);
        //return Image::make($the_image)->response('jpg', $quality);
        $storage_path = $path . '/screenshot.jpg';
        dd($storage_path);
        return Image::make($storage_path)->response();
    }
}
