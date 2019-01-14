<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminAuthentication
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
        // if user logged in as customer then redirect too home paage
        if (Auth::user()->role->name == 'customer') {
            return redirect('/home');
        }
        return $next($request);
    }
}
