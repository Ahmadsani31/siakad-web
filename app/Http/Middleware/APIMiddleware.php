<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class APIMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('Content-Type') !== 'application/json') {
            return response()->json(['message' => 'Only JSON requests are allowed.'], 415); // 415 Unsupported Media Type
        }

        if ($request->header('Accept') !== 'application/json') {
            return response()->json(['message' => 'Only JSON requests are allowed.'], 415); // 415 Unsupported Media Type
        }
        return $next($request);
    }
}
