<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedDomain = 'back-staging.bosraka.com';
        dd($request);
        if ($request->getHost() !== $allowedDomain) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
