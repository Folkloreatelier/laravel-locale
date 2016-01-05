<?php namespace Folklore\LaravelLocale;

use Illuminate\Support\ServiceProvider;

class LocaleServiceProvider extends ServiceProvider {

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
		$this->bootPublishes();
	}
	
	protected function bootPublishes()
	{
		$configPath = __DIR__ . '/../../config/locale.php';
		
		$this->mergeConfigFrom($configPath, 'locale');
		
		$this->publishes([
			$configPath => config_path('locale.php')
		], 'config');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerMiddlewares();
		$this->registerEventHandlers();
	}
	
	public function registerMiddlewares()
	{
		$http = $this->app['Illuminate\Contracts\Http\Kernel'];
		$http->pushMiddleware('Folklore\LaravelLocale\LocaleMiddleware');
	}
	
	public function registerEventHandlers()
	{
		$this->app['events']->subscribe('Folklore\LaravelLocale\LocaleEventHandler');
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