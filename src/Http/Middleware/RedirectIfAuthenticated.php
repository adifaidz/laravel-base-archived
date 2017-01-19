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
              case 'web_client':
                  $redirectRoute = 'client.home';
                  break;
              case 'web_admin':
                  $redirectRoute = 'admin.home';
                  break;
              default:
                  $redirectRoute = 'client.home';
                  break;
          }

          return redirect()->route($redirectRoute);
        }

        return $next($request);
    }
}
