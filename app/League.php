<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class League extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'gm_id',
        'slug'
    ];

    public function user() {
        return $this->hasOne('App\User', 'id', 'gm_id');
    }
}
