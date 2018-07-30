<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
	protected $fillable = [
		'name',
		'title',
		'description',
		'image'
		];

	public function seoable()
	{
		return $this->morphTo();
	}
}
