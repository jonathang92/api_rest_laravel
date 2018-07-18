<?php

namespace App\Http\Middleware;

use Closure;

class Preflight
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next )
    {
        if ($request->getMethod() === "OPTIONS") {
            return response('')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token, authorization, X-Requested-With');
        }
        return $next($request);
    }
}
