<?php

namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    public function handle(Request $request, Closure $next): Response
    {
        // check user if login 
        if (!$request->user()) {
            return response('Unauthorized', 401);
        }
        return $next($request);
    }
}
