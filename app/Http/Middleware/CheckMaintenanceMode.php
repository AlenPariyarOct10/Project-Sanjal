<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SystemInfo;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow admin related routes to pass through so admin can disable maintenance mode
        if ($request->is('admin') || $request->is('admin/*') || $request->is('login') || $request->is('logout') || $request->is('system-info*')) {
            return $next($request);
        }

        try {
            // Check if maintenance mode is enabled
            $maintenanceMode = SystemInfo::where('key', 'maintenance_mode')->value('value');
            
            if ($maintenanceMode === '1') {
                return response()->view('errors.maintenance', [], 503);
            }
        } catch (\Exception $e) {
            // If table doesn't exist or other DB error, just continue
        }

        return $next($request);
    }
}
