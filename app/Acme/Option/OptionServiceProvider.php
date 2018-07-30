<?php

namespace Acme\Option;

use Illuminate\Support\ServiceProvider;

class OptionServiceProvider extends ServiceProvider 
{
	public function register()
	{
		$this->app->bind('option', '\Acme\Option\Option');
	}
}