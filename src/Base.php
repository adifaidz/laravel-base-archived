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
}
