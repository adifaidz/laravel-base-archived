<?php

namespace AdiFaidz\Base\Providers;

use Illuminate\Support\ServiceProvider;
use AdiFaidz\Base\Commands as Commands;

class BaseServiceProvider extends ServiceProvider
{
    protected $providers = [
      \Laratrust\LaratrustServiceProvider::class,
      \AdiFaidz\Clean\Providers\CleanServiceProvider::class,
      \Lavary\Menu\ServiceProvider::class,
    ];

    protected $devProviders = [
      \Barryvdh\Debugbar\ServiceProvider::class,
      \Laralib\L5scaffold\GeneratorsServiceProvider::class,
      \Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class,
    ];

    protected $facades = [
      'Laratrust' => \Laratrust\LaratrustFacade::class,
      'Menu' => \Lavary\Menu\Facade::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(){
        $this->loadMigrations();
        $this->loadViews();

        if($this->app->runningInConsole()){
            $this->registerCommands();
            $this->publishConfigs();
            $this->publishViews();
            $this->publishVueComponents();
        }
    }

    /**
     * [loadMigrations description]
     */
    public function loadMigrations(){
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }

    /**
     * [loadViews description]
     */
    public function loadViews(){
        $this->loadViewsFrom(__DIR__.'/../../resources/assets/views', 'base');
    }

    /**
     * [registerCommands description]
     */
    public function registerCommands(){
        $this->commands([
            Commands\BaseMakeCommand::class,
            Commands\ModelMakeCommand::class,
            Commands\ControllerMakeCommand::class,
            Commands\ApiControllerMakeCommand::class,
            Commands\ViewMakeCommand::class,
            Commands\TransformerMakeCommand::class,
            Commands\PaginatorMakeCommand::class,
            Commands\ResourceMakeCommand::class,
        ]);
    }

    /**
     * [publishConfigs description]
     */
    public function publishConfigs(){
        $this->publishes([
          __DIR__.'/../../config/chart.php' => config_path('chart.php'),
        ]);
    }

    /**
     * [publishViews description]
     */
    public function publishViews(){
        $this->publishes([
          __DIR__.'/../../resources/views' => resource_path('views/vendor/base'),
        ], 'base-views');
    }

    /**
     * [publishVueComponents description]
     */
    public function publishVueComponents(){
        $this->publishes([
          __DIR__.'/../../resources/assets/js/components/base' => resource_path('assets/js/components/base'),
        ], 'base-components');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(){
        $this->instances = [];

        $this->registerProviders();

        $this->registerDevProviders();

        $this->registerFacades();
    }

    /**
     * [registerProviders description]
     */
    public function registerProviders(){
        foreach ($this->providers as $provider) {
            $this->instances[] = $this->app->register($provider);
        }
    }

    /**
     * [registerDevProviders description]
     */
    public function registerDevProviders(){
        if ($this->app->environment(config('chart.dev_env'))) {
            foreach ($this->devProviders as $provider) {
                $this->instances[] = $this->app->register($provider);
            }
        }
    }

    /**
     * [registerFacades description]
     */
    public function registerFacades(){
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        foreach ($this->facades as $alias => $facade) {
            $loader->alias($alias, $facade);
        }
    }

    /**
     * [provides description]
     */
    public function provides(){
        $provides = [];

        foreach ($this->providers as $provider) {
            $instance = $this->app->resolveProviderClass($provider);
            $provides = array_merge($provides, $instance->provides());
        }

        return $provides;
    }
}
