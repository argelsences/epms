<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Speaker extends Model
{
    //
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'profile', 'photo', 'department_id', 
    ];

    public function events(){
        return $this->belongsToMany('App\Event')->withTimestamps();
    }

    public function scopeFilterByDepartment($query) {
        return $query->where('department_id', auth()->user()->department_id);
    }
}
