<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
	protected $fillable = [
	'name',
	'slug',
	'type',
	'value',
	'asset',
	];

	public function scopeSlug($query, $slug)
	{
		return $query->whereSlug($slug)->first();
	}
}
