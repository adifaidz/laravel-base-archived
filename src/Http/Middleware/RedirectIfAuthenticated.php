<?php

namespace AdiFaidz\Base\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
          switch ($guard) {
              case config('base.client_guard'):
                  $routeName = config('base.redirect.auth_client');
                  break;
              case config('base.admin_guard'):
                  $routeName = config('base.redirect.auth_admin');
                  break;
              default:
                  $routeName = config('base.redirect.auth_default');
                  break;
          }

          return redirect()->route($routeName);
        }

        return $next($request);
    }
}
