<?php

namespace AdiFaidz\Base\Http\Middleware;

use Closure;
use Menu;

class AdminMenu
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
          $menu->add('Admin Home', ['route' => 'admin.home', 'icon' => 'fa fa-dashboard']);
        });

        return $next($request);
    }
}
