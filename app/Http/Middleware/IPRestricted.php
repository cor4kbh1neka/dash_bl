<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IPRestricted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIPs = ['https://bosraka.com'];
        $allowedIPs = array_map('gethostbyname', $allowedIPs);

        if (!in_array($request->ip(), $allowedIPs)) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
