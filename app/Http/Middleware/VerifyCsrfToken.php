<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    public function handle($request, Closure $next)
    {
        //add this condition
        if (config('front.exceptVerifyCsrfToken')) {
            foreach (config('front.exceptVerifyCsrfToken') as $route) {
                if ($request->is($route)) {
                    return $next($request);
                }
            }
        }

        return parent::handle($request, $next);
    }
}
