<?php

namespace AdiFaidz\Base\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BlockIfNotOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $varName, $getUserMethod = null, $redirectTo = null)
    {
        $user = null;
        if(!empty($getUserMethod) && strtolower($getUserMethod) !== 'null'){
          $user = $request->$varName->$getUserMethod;
        }
        else{
          $user = $request->$varName;
        }

        if($user->id !== Auth::user()->id){
          if(!empty($redirectTo) && strtolower($redirectTo) !== 'null'){
            return redirect($redirectTo);
          }
          return abort('403');
        }

        return $next($request);
    }
}
