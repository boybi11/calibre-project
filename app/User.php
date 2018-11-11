<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'front_user_type',
        'token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function leagues() {
        return $this->belongsToMany('App\League');
    }

    public function tasks()
    {
        return $this->belongsToMany('App\Task')->withPivot(['status', 'score']);
    }
}
