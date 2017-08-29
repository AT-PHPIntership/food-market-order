<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request It is request from client
     * @param \Closure                 $next    It is closure
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $trustedDomains = explode(',', env('TRUST_DOMAIN'));
        if (isset($request->server()['HTTP_ORIGIN'])) {
            $origin = $request->server()['HTTP_ORIGIN'];
            if (in_array($origin, $trustedDomains)) {
                header('Access-Control-Allow-Origin: ' . $origin);
                header('Access-Control-Allow-Headers: Content-Type, Accept, Authorization');
            }
        }
        return $next($request);
    }
}
