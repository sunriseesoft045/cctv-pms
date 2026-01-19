<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated.
        if (!Auth::check()) {
            // If the user is not authenticated, redirect them to the general login page using the named route.
            return redirect()->route('login');
        }

        // Allow only admin role.
        // If the authenticated user does not have an 'admin' role, abort with a 403 Forbidden error.
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        // Check if user is active.
        // If the user's account is not active, log them out and redirect to the login page with an error message.
        if (!auth()->user()->isActive()) {
            auth()->logout();
            return redirect('/login')->with('error', 'Your account has been deactivated');
        }

        return $next($request);
    }
}
