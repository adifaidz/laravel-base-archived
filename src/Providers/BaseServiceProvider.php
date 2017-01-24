<?php

namespace AdiFaidz\Base\Providers;

use Illuminate\Support\ServiceProvider;
use AdiFaidz\Base\Commands as Commands;

class BaseServiceProvider extends ServiceProvider
{
    protected $providers = [
      \Laratrust\LaratrustServiceProvider::class,
      ComposerServiceProvider::class,
      \AdiFaidz\Clean\Providers\CleanServiceProvider::class,
      \Lavary\Menu\ServiceProvider::class,
    ];

    protected $devProviders = [
      \Barryvdh\Debugbar\ServiceProvider::class,
      \Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class,
    ];

    protected $facades = [
      'Laratrust' => \Laratrust\LaratrustFacade::class,
      'Menu' => \Lavary\Menu\Facade::class,
    ];

    protected $middleware = [
      'base_guest' => \AdiFaidz\Base\Http\Middleware\RedirectIfAuthenticated::class,
      'role' => \Laratrust\Middleware\LaratrustRole::class,
      'permission' => \Laratrust\Middleware\LaratrustPermission::class,
      'ability' => \Laratrust\Middleware\LaratrustAbility::class,
    ];

    protected $command = [
        Commands\BaseInstallCommand::class,
        Commands\BaseMakeCommand::class,
        Commands\ModelMakeCommand::class,
        Commands\ControllerMakeCommand::class,
        Commands\ApiControllerMakeCommand::class,
        Commands\ViewMakeCommand::class,
        Commands\TransformerMakeCommand::class,
        Commands\PaginatorMakeCommand::class,
        Commands\ResourceMakeCommand::class,
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
            $this->publishPublic();
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
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'base');
    }

    /**
     * [registerCommands description]
     */
    public function registerCommands(){
        $this->commands($this->command);
    }

    /**
     * [publishConfigs description]
     */
    public function publishConfigs(){
        $this->publishes([
          __DIR__.'/../../config/base.php' => config_path('base.php'),
          __DIR__.'/../../config/basetrust.php' => config_path('basetrust.php'),
          __DIR__.'/../../config/base_seeder.php' => config_path('base_seeder.php'),
          __DIR__.'/../../config/debugbar.php' => config_path('debugbar.php'),
          __DIR__.'/../../config/laravel-menu/settings.php' => config_path('laravel-menu/settings.php'),
          __DIR__.'/../../config/laravel-menu/views.php' => config_path('laravel-menu/views.php'),
        ], 'config');
    }

    /**
     * [publishViews description]
     */
    public function publishViews(){
        $this->publishes([
          __DIR__.'/../../resources/views' => resource_path('views/vendor/base'),
        ], 'views');
    }

    /**
     * [publishVueComponents description]
     */
    public function publishVueComponents(){
        $this->publishes([
          __DIR__.'/../../resources/assets/js/components/base' => resource_path('assets/js/components/base'),
        ], 'vue');
    }

    /**
     * [publishPublic description]
     */
    public function publishPublic(){
        $this->publishes([
          __DIR__.'/../../public' => public_path('vendor/base'),
        ], 'public');
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

        $this->registerConfigs();
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
        if ($this->app->environment(config('base.dev_env'))) {
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
     * [registerConfigs description]
     */
    public function registerConfigs(){
        config([
          'laratrust.role' => config('basetrust.role.model'),
          'laratrust.roles_table' => config('basetrust.roles_table.table'),
          'laratrust.permission' => config('basetrust.permission.model'),
          'laratrust.permissions_table' => config('basetrust.permissions_table.table'),
          'laratrust.permission_role_table' => config('basetrust.permission_role_table'),
          'laratrust.role_user_table' => config('basetrust.role_user_table'),
          'laratrust.user_foreign_key' => config('basetrust.user_foreign_key'),
          'laratrust.role_foreign_key' => config('basetrust.role_foreign_key'),
          'laratrust.permission_foreign_key' => config('basetrust.permission_foreign_key'),
          'laratrust.middleware_handling' => config('basetrust.middleware_handling'),
          'laratrust.middleware_params' => config('basetrust.middleware_params'),
        ]);
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
