<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendee extends Model
{
    //
    use SoftDeletes;
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

    public function event(){
        return $this->belongsTo('App\Event');
    }

    public function getFullNameAttribute(){
        return $this->first_name . " " . $this->last_name;
    }

    public function scopeFilterByDepartment($query) {
        return $query->where('department_id', auth()->user()->department_id);
    }
}
