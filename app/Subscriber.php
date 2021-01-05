<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'token', 'department_id', 
    ];

    public function department(){
        return $this->belongsTo('App\Department');
    }
}
