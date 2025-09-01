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
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.maintenance_mode')) {
            if(auth()->check() && auth()->user()->hasRole('superadmin')) {
                return $next($request);
            }
            return response()->view('maintenance');
        }
        return $next($request);
    }
}
