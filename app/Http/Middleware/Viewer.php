<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Viewer as ViewerModel;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;

class Viewer
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
        if (!application_installed()) {
            return $next($request);
        }

        if ($request->method() == 'GET' && !$request->is('admin*')) {

            $options = [];
            $agent   = new Agent();

            $options['device']    = $agent->device();
            $options['platform']  = $agent->platform();
            $options['browser']   = $agent->browser();
            $options['robot']     = $agent->robot();
            $options['method']    = request()->method();
            $options['referer']   = request()->headers->get('referer');

            ViewerModel::create([
                'ip'      => request()->ip(),
                'path'    => request()->getRequestUri(),
                'auth'    => auth()->check(),
                'user_id' => auth()->check() ? auth()->user()->id : null,
                'options' => json_encode($options)
            ]);

            Cache::increment('admin.views-count-' . now()->format('Y-m-d'));
        }

        return $next($request);
    }
}
