# STEP 1 → Middleware Code
# File: app/Http/Middleware/AdminMiddleware.php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

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

        // Retrieve the authenticated user.
        $user = Auth::user();

        // Check if the user's role is 'admin'.
        // If the authenticated user does not have an 'admin' role, abort with a 403 Forbidden error.
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        // Check if user account is active.
        // If the user's account is not active, log them out and redirect to the login page with an error message.
        if (!$user->isActive()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('error', 'Your account has been deactivated');
        }

        return $next($request);
    }
}

# STEP 2 → Kernel Registration
# File: app/Http/Kernel.php
<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \Illuminate\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        
        // Custom Middleware
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'user' => \App\Http\Middleware\UserMiddleware::class,
        'master-admin' => \App\Http\Middleware\MasterAdminMiddleware::class, # Added registration for MasterAdminMiddleware
    ];
}

# STEP 3 → Route Fix
# File: routes/web.php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\SystemSettingsController;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\FinancialController;

// Root redirect: Redirects the base URL to the general login page using the named 'login' route.
Route::get('/', function () {
    return redirect()->route('login');
});

// General Login Route - points to the admin login form as the primary login for the application.
// This route is named 'login' to be compatible with Laravel's default authentication scaffolding
// and to serve as the default redirect for unauthenticated users.
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

// Admin Authentication Routes (Without Middleware) - This group is now redundant for login form display,
// as the general '/login' route handles it. However, it keeps the 'admin.login' named route for consistency
// if internal admin-specific redirects are preferred.
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
});

// Admin Protected Routes (With AdminMiddleware)
// These routes are accessible only to authenticated users with the 'admin' role.
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard route for administrators.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Routes for managing reports.
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/reports/{id}', [ReportsController::class, 'show'])->name('reports.show');
    Route::get('/reports/export/csv', [ReportsController::class, 'export'])->name('reports.export');

    // Logout route for administrators.
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Master Admin Protected Routes (With MasterAdminMiddleware)
// These routes are accessible only to authenticated users with the 'master-admin' role.
Route::prefix('admin')->middleware(['auth', 'master-admin'])->name('admin.')->group(function () {
    // Admin Management routes.
    Route::get('/admins', [AdminManagementController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [AdminManagementController::class, 'create'])->name('admins.create');
    Route::post('/admins', [AdminManagementController::class, 'store'])->name('admins.store');
    Route::get('/admins/{id}/edit', [AdminManagementController::class, 'edit'])->name('admins.edit');
    Route::put('/admins/{id}', [AdminManagementController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{id}', [AdminManagementController::class, 'destroy'])->name('admins.destroy');

    // System Settings routes.
    Route::get('/system-settings', [SystemSettingsController::class, 'index'])->name('system-settings.index');
    Route::put('/system-settings', [SystemSettingsController::class, 'update'])->name('system-settings.update');

    // Company Profile routes.
    Route::get('/company-profile', [CompanyProfileController::class, 'index'])->name('company-profile.index');
    Route::put('/company-profile/{id?}', [CompanyProfileController::class, 'update'])->name('company-profile.update');

    // Financial Management routes.
    Route::get('/financial', [FinancialController::class, 'index'])->name('financial.index');
    Route::get('/financial/create', [FinancialController::class, 'create'])->name('financial.create');
    Route::post('/financial', [FinancialController::class, 'store'])->name('financial.store');
    Route::get('/financial/{id}', [FinancialController::class, 'show'])->name('financial.show');
    Route::get('/financial/{id}/edit', [FinancialController::class, 'edit'])->name('financial.edit');
    Route::put('/financial/{id}', [FinancialController::class, 'update'])->name('financial.update');
    Route::delete('/financial/{id}', [FinancialController::class, 'destroy'])->name('financial.destroy');
});


# STEP 4 → AuthController Fix
# File: app/Http/Controllers/AdminAuthController.php
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


# STEP 5 → Session & ENV Fix
# File: .env (Updated sections)
# APP_URL is set to http://localhost:8000
# SESSION_DRIVER is set to file
APP_URL=http://localhost:8000
SESSION_DRIVER=file

# File: config/session.php (No changes needed, as it correctly reads from .env)
# The 'driver' is set to env('SESSION_DRIVER', 'database'), which will now pick up 'file' from .env.
# No direct code change required in this file.

# STEP 6 → Artisan Debug Commands
# Run these commands in your project root to clear various caches.
# Clearing route cache
php artisan route:clear
# Clearing config cache
php artisan config:clear
# Clearing view cache
php artisan view:clear
# Clearing application cache (this also clears session data if file driver is used)
php artisan cache:clear

# STEP 7 → Test Checklist
# Follow these steps to verify the fixes:

# 1. Clear all caches:
#    Run the artisan commands provided in STEP 6.

# 2. Access /admin/dashboard as a guest:
#    Expected behavior: Should be redirected to /login.

# 3. Attempt to login with non-admin credentials (e.g., user role):
#    Expected behavior: Should be able to log in, but attempting to access /admin/dashboard should result in a 403 error.

# 4. Attempt to login with invalid credentials:
#    Expected behavior: Should return back to the login page with an "Invalid credentials" error.

# 5. Attempt to login as an 'admin' with correct credentials and 'admin' role selected:
#    Expected behavior: Should successfully log in and be redirected to /admin/dashboard.

# 6. Access /admin/dashboard as a logged-in admin:
#    Expected behavior: Should successfully view the admin dashboard.

# 7. Test logout:
#    Expected behavior: After logging out, should be redirected to /login.

# 8. Test Master Admin routes:
#    Attempt to access a master admin route (e.g., /admin/admins) with a regular admin user.
#    Expected behavior: Should result in a 403 error.

#    Attempt to access a master admin route with a master admin user.
#    Expected behavior: Should successfully view the master admin page.