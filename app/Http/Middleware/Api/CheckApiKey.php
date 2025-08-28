<?php

namespace App\Http\Middleware\Api;

use Closure;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

      // Exclude a specific route
    if ($request->is('api/development/qrcode/show') || $request->is('api/development/qrcode') ) {
        return $next($request);
    }
        if ( !env('API_KEY') || $request->header('x-api-key') !== env('API_KEY')) {

            return apiResponse2(0, 'client_identity_error', 'client identification failed.check the api key');
        }
        return $next($request);
    }
}
