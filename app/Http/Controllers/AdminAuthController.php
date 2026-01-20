<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * Show Admin Login Form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            // Redirect based on role after login
            $user = Auth::user();
            if ($user->role === 'master_admin' || $user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === 'user') {
                return redirect()->intended('/user/dashboard');
            }
        }
        return view('admin.auth.login');
    }

    /**
     * Handle Admin Login
     */
    public function login(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:master_admin,admin,user',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // Check user existence and password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials. Please try again.'])->withInput();
        }

        // Check role mismatch
        if ($user->role !== $request->role) {
            return back()->withErrors(['role' => 'Role mismatch. Please select your correct role.'])->withInput();
        }

        // Check account status
        if ($user->status !== 'active') {
            return back()->withErrors(['email' => 'This account is inactive. Please contact support.'])->withInput();
        }

        // Log in the user
        Auth::login($user);

        // Regenerate session
        $request->session()->regenerate();

        // Redirect based on role
        if ($user->role === 'master_admin' || $user->role === 'admin') {
            return redirect()->intended('/admin/dashboard')->with('success', 'Welcome back, ' . $user->name);
        } elseif ($user->role === 'user') {
            return redirect()->intended('/user/dashboard')->with('success', 'Welcome back, ' . $user->name);
        }

        // Fallback redirect
        return redirect('/login');
    }

    /**
     * Handle Admin Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
