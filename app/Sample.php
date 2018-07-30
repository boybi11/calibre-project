<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;  

class Sample extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
    	'name',
    	'range',
    	'image',
    	'runes',
    	'embedded_rune',
    	'evaluation'
    	];


    public function image()
    {
    	return $this->hasOne('App\Asset', 'image');
    }

    public function seo()
    {
        return $this->morphMany('App\Seo', 'seoable');
    }

    //field to use for activity logging
    protected static $identifier_field = 'name';
    public function activities()
    {
        return $this->morphMany('App\Activity', 'loggable');
    }

    // public function _paginate($data, $request, $input = array())
    // {
    //     return parent::_paginate($data, $request, $input);
    // }
}
