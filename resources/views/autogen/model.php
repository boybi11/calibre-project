<?php

namespace App;

use Acme\Model\BaseModel;
use Illuminate\Database\Eloquent\Model;{$SOFT_DELETE_INJECT}

class {$MODEL} extends BaseModel
{
    {$SOFT_DELETE_USE}
    protected $fillable = [
    	{$COLUMNS}
    	];
    {$DATES}{$HAS_IMAGE}
    
    public function seo()
    {
        return $this->morphMany('App\Seo', 'seoable');
    }
    
    public function activities()
    {
        return $this->morphMany('App\Activity', 'loggable');
    }
}
