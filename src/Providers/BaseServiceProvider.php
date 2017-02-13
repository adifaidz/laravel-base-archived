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

    protected $configs = [
      'base' => [
        'src' => __DIR__.'/../../config/base.php',
        'dest' => 'base.php',
      ],
      'basetrust' => [
        'src' => __DIR__.'/../../config/basetrust.php',
        'dest' => 'basetrust.php',
      ],
      'base_seeder' => [
        'src' => __DIR__.'/../../config/base_seeder.php',
        'dest' => 'base_seeder.php',
      ],
      'debugbar' => [
        'src' => __DIR__.'/../../config/debugbar.php',
        'dest' => 'debugbar.php',
      ],
      'laravel-menu.settings' => [
        'src' => __DIR__.'/../../config/laravel-menu/settings.php',
        'dest' => 'laravel-menu/settings.php',
      ],
      'laravel-menu.views' => [
        'src' => __DIR__.'/../../config/laravel-menu/views.php',
        'dest' => 'laravel-menu/views.php',
      ],
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
        $this->mergeConfigs();

        if($this->app->runningInConsole()){
            $this->registerCommands();
            $this->publishConfigs();
            $this->publishViews();
            $this->publishVueComponents();
            $this->publishPublic();
            $this->publishViewStub();
            $this->publishVueStub();
        }
    }

    /**
     * [loadMigrations description]
     */
    public function loadMigrations(){
        if ($this->app->environment('testing')){
          $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/tests');
        }
        else{
          $this->loadMigrationsFrom(__DIR__.'/../../database/migrations/src');
        }
    }

    /**
     * [loadViews description]
     */
    public function loadViews(){
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'base');
    }

    /**
     * [mergeConfigs description]
     */
    public function mergeConfigs(){

        foreach ($this->configs as $key => $path) {
            $this->mergeConfigFrom($path['src'], $key);
        }
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
        $configs = [];

        foreach ($this->configs as $path) {
          $src  = $path['src'];
          $dest = $path['dest'];
          $configs[$src] = config_path($dest);
        }

        $this->publishes($configs, 'config');
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
     * [publishViewStub description]
     */
    public function publishViewStub(){
        $this->publishes([
          __DIR__.'/../Commands/stubs/views' => resource_path('stubs/views'),
        ], 'stub-view');
    }

    /**
     * [publishVueStub description]
     */
    public function publishVueStub(){
        $this->publishes([
          __DIR__.'/../Commands/stubs/vue' => resource_path('stubs/vue'),
        ], 'stub-view');
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
          'laratrust.role' => config('basetrust.role'),
          'laratrust.roles_table' => config('basetrust.roles_table'),
          'laratrust.permission' => config('basetrust.permission'),
          'laratrust.permissions_table' => config('basetrust.permissions_table'),
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
