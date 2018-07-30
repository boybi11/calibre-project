<?php

namespace Acme\Seo;

use Illuminate\Support\ServiceProvider;

class SeoServiceProvider extends ServiceProvider 
{
	public function register()
	{
		$this->app->bind('seo', '\Acme\Seo\Seo');
	}
}