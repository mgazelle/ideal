<?php namespace Mgazelle\Ideal;

use Illuminate\Support\ServiceProvider;

class IdealServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        // Laravel 4 package registration
        if (method_exists($this, 'package'))
        {
            $this->package('mgazelle/ideal');
        }
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
        return array('Ideal');
	}

}
