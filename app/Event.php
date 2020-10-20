<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Event extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['start_date', 'end_date'];
}
