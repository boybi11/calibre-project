<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    
    protected $fillable = [
    	'name',
        'slug',
        'integer',
        'image',
        'image_thumbnail',
        'enum',
        'text',
    	];
    
 	public function image()
	{
		return $this->hasOne('App\Test', 'image');
	}
    
    public function seo()
    {
        return $this->morphMany('App\Seo', 'seoable');
    }
    
}
