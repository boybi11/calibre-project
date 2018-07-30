<?php

namespace Acme\Activity;

use Illuminate\Support\ServiceProvider;

class ActivityServiceProvider extends ServiceProvider 
{
	public function register()
	{
		$this->app->bind('activity', '\Acme\Activity\Activity');
	}
}