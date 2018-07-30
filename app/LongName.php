<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LongName extends Model
{
    
    protected $fillable = [
    	'name',






    	];
    

	{
		return $this->hasOne('App\LongName', 'image');
	}
    
    public function seo()
    {
        return $this->morphMany('App\Seo', 'seoable');
    }
    
}