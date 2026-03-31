<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureForceChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->force_to_password_change) {
            return $next($request);
        }

        abort(404);
    }
}
