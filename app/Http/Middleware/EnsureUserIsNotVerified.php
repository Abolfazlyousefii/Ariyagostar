<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsNotVerified
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
        $check_for_verify = option('sms_to_verify_user', 'off');

        if ($request->user()->verified_at || $check_for_verify == 'off') {
            return redirect('/');
        }

        return $next($request);
    }
}
