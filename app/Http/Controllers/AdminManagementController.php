<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    /**
     * Show all admins
     */
    public function index()
    {
        $users = User::where('role', '!=', 'master_admin')->paginate(10);
        return view('admin.admin-management.index', compact('users'));
    }

    /**
     * Show create admin form
     */
    public function create()
    {
        return view('admin.admin-management.create');
    }

    /**
     * Store new admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'active',
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin created successfully');
    }

    /**
     * Show edit admin form
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.admin-management.edit', compact('user'));
    }

    /**
     * Update admin
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,user,master_admin',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.admins.index')->with('success', 'User updated successfully');
    }

    /**
     * Delete admin
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent master admin from deleting themselves or other master admins
        if ($user->isMasterAdmin()) {
            return back()->with('error', 'Master admin accounts cannot be deleted through this interface.');
        }

        $user->delete();
        return redirect()->route('admin.admins.index')->with('success', 'User deleted successfully');
    }
}
