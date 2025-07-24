<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OptimizeFileResponse
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Optimize for file uploads to Laravel Cloud
        if ($request->hasFile('store_icon') || $request->hasFile('foto')) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        return $response;
    }
} 