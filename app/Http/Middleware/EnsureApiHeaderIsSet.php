<?php

namespace App\Http\Middleware;

use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Models\Apikey;
use Closure;
use Illuminate\Http\Request;

class EnsureApiHeaderIsSet
{
    use ApiResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $api_key = $request->header('x-api-key');

        if ($api_key) {
            if (Apikey::where('key', $api_key)->where('is_active', true)->first()) {
                return $next($request);
            }
        }

        return $this->respondForbidden('please set x-api-key header correctly');
    }
}
