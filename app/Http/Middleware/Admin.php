<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if($user = \Auth::user()) {
            if($user->role == 1) {
                return $next($request);
            }
            return redirect('home');
        }
        return redirect('home');
    }
}
