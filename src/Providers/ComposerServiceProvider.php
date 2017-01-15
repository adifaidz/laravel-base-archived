<?php

namespace Chart\Providers;

use Illuminate\Support\ServiceProvider;

use AdiFaidz\Base\Composers as Composers;

class ComposerServiceProvider extends ServiceProvider
{
    protected $composers = [
      'base::layouts.admin, base::layouts.client' => Composers\UserComposer::class,
    ];

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        foreach ($composers as $matchViews => $composer) {
            $views = array_map('trim', explode(',', $matchViews));

            view()->composer($views, $composer);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
