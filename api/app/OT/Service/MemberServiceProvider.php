<?php namespace OT\Service;

use Illuminate\Support\ServiceProvider;

 class MemberServiceProvider extends ServiceProvider{

	 /**
	  * Register the service provider.
	  *
	  * @return void
	  */
	 public function register()
	 {
	     // Register 'Rtext' instance container to our UnderlyingClass object
	     $this->app['member'] = $this->app->share(function($app)
	     {
	         return new \OT\Member;
	     });

	     // Shortcut so developers don't need to add an Alias in app/config/app.php
	     $this->app->booting(function()
	     {
	         $loader = \Illuminate\Foundation\AliasLoader::getInstance();
	         $loader->alias('Member', 'OT\Facade\Member');
	     });
	 }

 }