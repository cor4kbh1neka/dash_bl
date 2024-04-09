<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureReferer
{
    public function handle($request, Closure $next)
    {
        $referer = $request->header('referer');
        return $next($referer);
    }
}
