<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Poster extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['file_path', 'poster_code', 'created_by', 'edited_by', 'template_id', 'event_id'];

    public function event(){
        return $this->belongsTo('App\Event');
    }

    public function user(){
        return $this->belongsTo('App\User', 'created_by');
    }
}
