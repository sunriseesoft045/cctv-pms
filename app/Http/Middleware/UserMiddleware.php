<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        if (!auth()->user()->isUser()) {
            abort(403, 'Unauthorized access');
        }

        if (!auth()->user()->status || auth()->user()->status !== 'active') {
            auth()->logout();
            return redirect('/login')->with('error', 'Your account has been deactivated');
        }

        return $next($request);
    }
}