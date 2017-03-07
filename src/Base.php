<?php

namespace AdiFaidz\Base;

use Illuminate\Support\Facades\Route;

class Base
{
    public static function routes($callback = null, array $options = [])
    {
        $callback = $callback ?: function ($registrar) {
            $registrar->all();
        };
        $options = array_merge([
            'namespace' => '\AdiFaidz\Base\Http\Controllers',
        ], $options);

        Route::group($options, function ($router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }

    public static function mapBaseRoutes(){
      Route::middleware(['web','client'])
           ->namespace("App\Http\Controllers")
           ->prefix(config('base.client_route_prefix'))
           ->group(config('base.client_route'));

      Route::middleware(['web','admin'])
           ->namespace("App\Http\Controllers")
           ->prefix(config('base.admin_route_prefix'))
           ->group(config('base.admin_route'));
    }
}
