<?php

namespace AdiFaidz\Base;

class Base
{
    public static function routes($callback = null, array $options = [])
    {
        $callback = $callback ?: function ($router) {
            $router->all();
        };
        $options = array_merge([
            'namespace' => '\AdiFaidz\Base\Http\Controllers',
        ], $options);

        Route::group($options, function ($router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }
}
