<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReserveStatus extends Model
{
    //
    public function books(){
        return $this->hasMany('App\Book');
    }
}
