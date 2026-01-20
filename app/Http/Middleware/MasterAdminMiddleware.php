<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MasterAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect('/admin/login');
        }

        // Check if user is master_admin
        if (!auth()->user()->isMasterAdmin()) {
            abort(403, 'Only Master Admin can access this resource');
        }

        // Check if user is active
        if (!auth()->user()->isActive()) {
            auth()->logout();
            return redirect('/admin/login')->with('error', 'Your account has been deactivated');
        }

        return $next($request);
    }
}
