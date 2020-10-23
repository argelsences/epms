<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Carbon\Carbon;

class Event extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['start_date', 'end_date'];
    protected $fillable = ['title', 'synopsis', 'excerpt', 'start_date', 'end_date',
        'pre_booking_display_message', 'post_booking_display_message', 'social_show_facebook',
        'social_show_twitter', 'social_show_whatsapp', 'social_show_email', 'social_show_linkedin',
        'is_public', 'is_approved', 'for_approval', 'barcode_type', 'checkout_timeout',
        'department_id', 'created_by', 'edited_by', 'venue_id', 'poster_id',
    ];

    /**
     * Return dd mm YY @ h:i:s A
     */
    /*public function getStartDateAttribute($value){
        return (new Carbon($value))->format('j F Y @ h:i:s A');
    }*/

    /**
     * Evaluate value, if 0 then event is not yet published or under review, else Public
     */
    public function getIsPublicAttribute($value){
        return ($value) ? "Published" : "Private";
    }

    /**
     * Return venue name instead
     */
    /*
    public function getVenueIdAttribute($value){
        //return ($value) ? "Published" : "Private";
        return $this->venue->name;
    }
    */

    public function venue(){
        return $this->belongsTo('App\Venue');
    }
}
