<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsVerified
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

        if ($check_for_verify == 'off' || $request->user()->verified_at || $request->user()->force_to_password_change) {
            return $next($request);
        }

        if (config('front.routes.verify')) {
            $intended = request()->url();;

            app('redirect')->setIntendedUrl($intended);

            return redirect()->route(config('front.routes.verify'));
        }

        abort(403);
    }
}
