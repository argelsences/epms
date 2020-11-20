<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Ticket extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'max_per_person', 'min_per_person', 'quantity_available', 'quantity_booked', 'start_book_date',
        'end_book_date', 'is_paused', 'is_hidden', 'created_by', 'edited_by', 'event_id', 'department_id',
    ];

    public function event(){
        return $this->belongsTo('App\Event')->withTimestamps();
    }

}
