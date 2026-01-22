<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    /** List users */
    public function index()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /** Show create form */
    public function create()
    {
        return view('admin.users.create');
    }

    /** Store new user */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['status'] = 'active';
        User::create($data);

        return redirect()->route('admin.admins.index')->with('success', 'User created');
    }

    /** Show edit form */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /** Update user */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'status' => 'required|in:active,inactive',
        ]);

        $user->update($data);
        return redirect()->route('admin.admins.index')->with('success', 'User updated');
    }

    /** Delete user */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.admins.index')->with('success', 'User deleted');
    }
}
