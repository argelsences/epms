<?php

namespace App\Helpers;

use App\Template;
use Spatie\Browsershot\Browsershot;
use Storage;

class EPPMSHelper {

    public function thumbnail(Template $template){
        
        $file_path = $template->file_path;
        /////dd($file_path['path']);
        /////dd($template);
        /**
         * create a helper for this later
         */
        // the images
        /*
        $the_photos = [];

        foreach ($template->file_path['images'] as $image){
            $image_path = Storage::disk('local')->path($template->file_path['path'] . '/' . $image);
            $type = pathinfo($image_path, PATHINFO_EXTENSION);
            $data = Storage::disk('local')->get($template->file_path['path']. '/' . $image);
            $the_images[$image] = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }
        */
        // the template file
        /*
        $the_template_code = Storage::disk('local')->get($template->file_path['path']. '/' . $template->file_path['html_file']);
        $the_template_code = str_replace(["\n","\r","\t"],"",$the_template_code);
        */
        // the css file code
        /*
        $the_css_code = Storage::disk('local')->get($template->file_path['path']. '/' . $template->file_path['css_file']);
        $the_css_code = str_replace(["\n","\r","\t"],"",$the_css_code);
        */
        // piece them all together
        /*
        foreach ( $the_photos as $key=>$value ){
            $the_template_code = str_replace($key,$value,$the_template_code);
        }
        */
        // check if template directory and the html file is present (html file is the main driver for the thumb)
        /*
        if ( Storage::disk('local')->exists($template->file_path['path']) &&
            Storage::disk('local')->exists($template->file_path['path']. '/' . $template->file_path['html_file'])
        ){
            // generate the template html file to be used by poster generation
            Storage::disk('local')->put($template->file_path['path']. '/template_'.$template->id.'.html', $the_template_code );

            Browsershot::html($the_template_code)
                ->setOption('addStyleTag',json_encode(['content' => $the_css_code]))
                ->noSandbox()
                ->setScreenshotType('jpeg', 100)
                ->select('.poster')
                ->setDelay(1000)
                ->waitUntilNetworkIdle()
                ->save(Storage::disk('local')->path($template->file_path['path']. '/' .'screenshot.jpg' ));
        }

        // return false if screenshot was not created, else return true
        if ( !Storage::disk('local')->exists($template->file_path['path']. '/' .'screenshot.jpg') ){
            return false;
        }*/
        Browsershot::html($template->template_code)
                /////->setOption('addStyleTag',json_encode(['content' => $the_css_code]))
                ->noSandbox()
                ->setScreenshotType('jpeg', 100)
                /////->select('.poster')
                /////->setNodeBinary('/usr/bin/node')
                /////->setNpmBinary('/usr/bin/npm')
                /////->setIncludePath('$PATH:/usr/bin')
                ->setDelay(1000)
                ->waitUntilNetworkIdle()
                ->save(Storage::disk('local')->path('templates/'.$template->id. '/' .'screenshot.jpg' ));

        return true;
    }
}
