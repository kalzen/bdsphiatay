<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Auth;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        
        if (!$request->expectsJson()) {
            return route('login');
        }
      
    }
      public function handle($request, Closure $next, ...$guards)
        {
            if(Auth::check() && Auth::user()->role_id == 3)
            {
                return redirect()->route('index');
            }
            if (Auth::check()) {
                return $next($request);
            }
            return redirect()->route('login');
        }
}
