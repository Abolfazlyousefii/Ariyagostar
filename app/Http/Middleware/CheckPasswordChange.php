<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPasswordChange
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

            $currret_route = request()->route()->getName();



            if (config('front.routes.change-password') && config('front.routes.change-password-routes')) {

                if (!in_array($currret_route, config('front.routes.change-password-routes'))) {
                    $intended = request()->url();
                    app('redirect')->setIntendedUrl($intended);

                    return redirect()->route(config('front.routes.change-password'));
                }
            } else if (!in_array($currret_route, ['change-password'])) {
                $intended = request()->url();
                app('redirect')->setIntendedUrl($intended);

                return redirect()->route('change-password');
            }
        }

        return $next($request);
    }
}
