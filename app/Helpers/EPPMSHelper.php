<?php

namespace App\Helpers;

use App\Template;
use Spatie\Browsershot\Browsershot;
use Storage;
use Image;
use Illuminate\Support\Facades\Auth;
use App\Event;
use App\Poster;
use App\Book;
use PDF;

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

    /**
     * Generate poster
     * @TODO:
     * 1. Edit a poster object when an object exists for an event parent
     */
    public function generatePoster($params){
        //dd($params);
        $posterParams = $poster = $thePoster = [];
        $photo = $params['photo'];
        $id = $params['id'];

        $photo_filename  = $photo->getClientOriginalName();
        $file_path = $photo->storeAs("files/events/$id/poster", $photo_filename);

        // retrieve the event object
        $event = Event::findOrFail($id);
        // retrieve the poster object, if any
        $poster = Poster::where('event_id', $id)->first();
        
        $posterParams = [
            'file_path' => $file_path,
            'poster_code' => '',
            'event_id' => $id
        ];
        // check if we have an existing poster linked to event, if none, create one, else update it
        if ( $poster ){
            $posterParams['id'] = $poster->id;
            $posterParams = $this->setAuthorship($posterParams);
            $poster->update($posterParams);
        }
        else {
            $posterParams['id'] = 0;
            $posterParams = $this->setAuthorship($posterParams);
            // since this is new, we do not need the id key
            unset($posterParams['id']);
            $poster = Poster::create($posterParams);
        }
        
        return $poster;
    }
    /**
     * Generate PDF copy of booking tickets
     * @param $request as request object
     * @param $reference as event reference number
     * @param (optional) $attachment true if used for attachment
     * @return stream if request download is 1
     * or @return attachment if $attachment is true
     */
    public function booking_tickets($reference, $download = 0, $attachment = 0) {
        // the booking
        $booking = Book::where('booking_reference',$reference)->first();

        if (!$booking) {
            abort(404);
        }

        //$images = [];
        //$imgs = $booking->event->images;
        //foreach ($imgs as $img) {
            //$images[] = base64_encode(file_get_contents(public_path($img->image_path)));
        //}
        // get poster from the event
        $the_poster = '';
        $event = Event::findOrFail($booking->tickets->first()->event_id);
        
        if ($event->poster){
            if ($event->poster->file_path){
                $the_poster = base64_encode(file_get_contents(public_path($event->poster->file_path)));
            }
            elseif ($event->poster->poster_code){
                $the_poster = $event->poster->poster_code;
            }
        }

        $data = [
            'booking'   => $booking,
            'event'     => $event,
            'tickets'   => $booking->tickets,
            'attendees' => $booking->attendees,
            'css'       => file_get_contents(public_path('css/ticket.css')),
            'logo'      => base64_encode(file_get_contents(public_path($event->department->logo_path))),
            'poster'    => $the_poster,
        ];

        
        if ( $download ) {
            $pdf = PDF::loadView('front.pdf.ticket-pdf-html', compact('data'))->setPaper('a4', 'landscape');
            //$pdf = PDF::loadView('front.pdf.ticket-pdf2', compact('data'));
            return $pdf->stream( $reference.'.pdf' );
        }
        

        if( $attachment ) {
            $pdf = PDF::loadView('front.pdf.ticket-pdf-html', compact('data'))->setPaper('a4', 'landscape');
            //$pdf = PDF::loadView('front.pdf.ticket-pdf2', compact('data'));
            return $pdf->output();
        }
        
        return view('front.pdf.ticket-pdf-html', compact('data'));
    }
}
