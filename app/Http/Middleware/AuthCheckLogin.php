<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthCheckLogin
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
        if (empty(Auth::id())) {
            return redirect(route('auth.index'));
        }
        return $next($request);
    }
}
