<?php

namespace AdiFaidz\Base\Http\Middleware;

use Closure;
use Menu;

class ClientMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Menu::make('menu', function($menu){
          $menu->add('Client Home', ['route' => 'client.home', 'icon' => 'fa fa-dashboard']);
        });

        return $next($request);
    }
}
