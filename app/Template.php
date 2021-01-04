<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Template extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [ 'name', 'description', 'file_path', 'template_code', 'department_id','method'];

    public function getFilePathAttribute($value){
        return unserialize($value);
    }

    public function department(){
        return $this->belongsTo('App\Department');
    }

    public function scopeFilterByDepartment($query) {
        return $query->where('department_id', auth()->user()->department_id);
    }
}
