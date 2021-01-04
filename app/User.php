<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'designation', 'department_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department(){
        return $this->belongsTo('App\Department');
    }

    public function role() {
        return $this->roles()->first()->get();
    }

    /**
     * Check if user is author of an event
     */
    public function is_event_author($created_by){

        if (auth()->user()->id == $created_by )
            return true;
            
        return false;
    }

    /**
     * Check if user is administrator of a department
     */
    public function is_department_admin($department_id, $guard = 'web'){

        //dd(auth()->user()->hasRole('Administrator',$guard));
        //auth()->user()->department_id == $department_id && auth()->user()->hasRole('Administrator',$guard)

        if (auth()->user()->department_id == $department_id && auth()->user()->hasRole('Administrator',$guard) )
            return true;
            
        return false;
    }

    /**
     * Check if user is super admin
     */
    public function is_super_admin($guard = 'web') {

        dd(auth()->user()->hasRole('Super Administrator', $guard));
        if (auth()->user()->hasRole('Super Administrator', $guard))
            return true;

        return false;
    }

    public function posters(){
        return $this->hasMany('App\Poster');
    }
}
