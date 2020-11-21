<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Poster extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['file_path', 'poster_code', 'created_by', 'edited_by', 'template_id', 'event_id'];
}
