<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Add CORS headers to an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Request
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application')
            ->header('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, PATCH, DELETE');
        return $response;
    }
}
