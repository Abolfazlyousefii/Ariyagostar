<?php

namespace App\Http\Middleware;

use Closure;

class Language
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
        $locale = $request->segment(1);

        if (!$locale || !array_key_exists($locale, config('app.locales'))) {
            $locale = config('app.fallback_locale');
        }

        app()->setLocale($locale);
        return $next($request);
    }
}
