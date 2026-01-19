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
            return redirect('/admin/dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Handle Admin Login
     */
    public function login(Request $request)
    {
        // Validate incoming request data, including email, password, and the submitted role.
        // The 'role' field is assumed to come from a dropdown in the login form.
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user', // Assuming 'admin' and 'user' are the only valid roles
        ]);

        // Retrieve the user based on the provided email.
        $user = User::where('email', $request->email)->first();

        // Check if user exists and if the provided password matches the stored hashed password.
        if (!$user || !Hash::check($request->password, $user->password)) {
            // If user does not exist or password does not match, return with an error.
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        // Validate that the submitted role matches the user's actual role in the database.
        // This ensures a user cannot log in with an incorrect role, even with valid credentials.
        if ($user->role !== $request->role) {
            // If roles do not match, return with an error specific to role mismatch.
            return back()->withErrors(['role' => 'Role mismatch.'])->withInput();
        }

        // Check if user is an admin or master_admin.
        // This acts as an additional safeguard, ensuring only authorized roles proceed.
        if ($user->role !== 'admin' && $user->role !== 'master_admin') {
            return back()->withErrors(['email' => 'Access denied. Only admins can login'])->withInput();
        }

        // Check if user account is active.
        if ($user->status !== 'active') {
            return back()->withErrors(['email' => 'Your account is inactive'])->withInput();
        }

        // Log in the user and regenerate their session for security purposes.
        Auth::login($user);
        $request->session()->regenerate();

        // Redirect the authenticated admin to the admin dashboard with a success message.
        return redirect('/admin/dashboard')->with('success', 'Welcome back, ' . $user->name);
    }

    /**
     * Handle Admin Logout
     */
    public function logout(Request $request)
    {
        // Log out the currently authenticated user.
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token to prevent session fixation attacks.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the general login page after successful logout using the named route.
        return redirect()->route('login')->with('success', 'You have been logged out successfully');
    }
}
