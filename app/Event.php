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
