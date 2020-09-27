<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Template extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [ 'name', 'description', 'file_path', 'template_code', 'department_id'];
}
