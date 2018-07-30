<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel
{
    
    protected $fillable = [
    	'name',
        'slug',
        'image',
        'image_thumbnail',
    	];
    
 	public function asset()
	{
		return $this->hasOne('App\Asset', 'id', 'image');
	}
    
    public function seo()
    {
        return $this->morphMany('App\Seo', 'seoable');
    }
    
    public function activities()
    {
        return $this->morphMany('App\Activity', 'loggable');
    }
}
