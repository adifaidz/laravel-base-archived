<?php

namespace AdiFaidz\Base\Providers;

use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    protected $providers = [
      \Laratrust\LaratrustServiceProvider::class,
      \AdiFaidz\Clean\Providers\CleanServiceProvider::class,
      \Lavary\Menu\ServiceProvider::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->instances = [];
        foreach ($this->providers as $provider) {
            $this->instances[] = $this->app->register($provider);
        }

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Laratrust', 'Laratrust\LaratrustFacade');
        $loader->alias('Menu', 'Lavary\Menu\Facade');
    }

    public function provides()
    {
        $provides = [];
        foreach ($this->providers as $provider) {
            $instance = $this->app->resolveProviderClass($provider);
            $provides = array_merge($provides, $instance->provides());
        }
        return $provides;
    }
}
