<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Department extends Model
{
    //
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'facebook', 'instagram', 'logo_path', 'page_header_bg_color',
        'page_text_color', 'google_analytics_code', 'google_tag_manager_code', 'url', 'page_bg_color', 'about',
    ];

    public function events() {
        return $this->hasMany('App\Event');
    }

    public function getLogoPathAttribute($value){
        return ($value) ? $value :   config('eppms.default.logo');
    }

    public function subscribers(){
        return $this->hasMany('App\Subscriber');
    }

    public function scopeFilterByDepartment($query) {
        return $query->where('id', auth()->user()->department_id);
    }
}
