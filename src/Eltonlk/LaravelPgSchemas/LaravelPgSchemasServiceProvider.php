<?php namespace Eltonlk\LaravelPgSchemas;

use Illuminate\Support\ServiceProvider;

class LaravelPgSchemasServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('eltonlk/laravel-pg-schemas');

    $this->app->booting(function()
    {
      $loader = \Illuminate\Foundation\AliasLoader::getInstance();
      $loader->alias('PGSchema', 'Eltonlk\LaravelPgSchemas\Facades\PGSchema');
    });
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
    $this->app['pgschema'] = $this->app->share(function($app)
    {
        return new LaravelPgSchemas;
    });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
