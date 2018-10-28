<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Task extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'league_id',
        'slug',
        'description',
        'duration',
        'exp',
        'points',
        'status'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
