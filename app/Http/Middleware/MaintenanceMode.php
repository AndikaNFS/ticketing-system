<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika mode maintenance aktif dan bukan route maintenance
        if (env('APP_MAINTENANCE', false) && !$request->is('maintenance')) {
            return response()->view('maintenance');
        }
        
        return $next($request);
    }
}
