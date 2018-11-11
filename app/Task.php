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
        'status',
        'badge_leader',
        'badge_reward'
    ];

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot(['status', 'score']);
    }

    public function league()
    {
        return $this->hasOne('App\League', 'id', 'league_id');
    }
}
