<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'private_reference_number', 'reference_index', 'event_id', 'book_id', 'ticket_id', 
    ];

    public function book(){
        return $this->belongsTo('App\Book');
    }

    public function ticket(){
        return $this->belongsTo('App\Ticket');
    }
}
