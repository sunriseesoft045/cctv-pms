<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:master_admin,admin,user'
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        if ($user->role !== $request->role) {
            return back()->withErrors(['role' => 'Role mismatch']);
        }

        if ($user->status !== 'active') {
            return back()->withErrors(['email' => 'Account inactive']);
        }

        \Illuminate\Support\Facades\Auth::login($user);
        $request->session()->regenerate();

        return match ($user->role) {
            'master_admin', 'admin' => redirect('/admin/dashboard'),
            'user' => redirect('/user/dashboard'),
            default => abort(403),
        };
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
