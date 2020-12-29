<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Book extends Model
{
    //
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'business_name', 'business_address_line_1', 'business_address_line_2', 'business_address_state_province',
        'business_address_city', 'ticket_pdf_path', 'booking_reference', 'transaction_id', 'is_deleted', 'is_cancelled', 'reserve_status_id', 'event_id'
    ];

    public function book_items(){
        return $this->hasMany('App\BookItem');
    }

    public function attendees(){
        return $this->hasMany('App\Attendee');
    }

    public function reserve_status(){
        return $this->belongsTo('App\ReserveStatus');
    }

    public function tickets(){
        return $this->belongsToMany('App\Ticket');
    }

    /**
     * Return dd mm YY @ h:i:s A
     */
    public function createdDateFormatted(){
        return (new Carbon($this->created_at))->format('j F Y h:i A');
    }
}
