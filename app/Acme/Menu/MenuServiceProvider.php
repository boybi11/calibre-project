<?php

namespace Acme\Menu;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider 
{
	public function register()
	{
		$this->app->bind('menu', '\Acme\Menu\Menu');
	}
}