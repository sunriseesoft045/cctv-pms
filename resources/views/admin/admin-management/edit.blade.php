@extends('admin.layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
    <div class="page-header">
        <h1><i class="fas fa-user-edit"></i> Edit User</h1>
        <p>Update user account details and permissions</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-check"></i> User Details
                </div>
                <div class="card-body">
                    <form action="{{ route('admins.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user"></i> Full Name
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                placeholder="Enter user full name" 
                                value="{{ old('name', $user->name) }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> Email Address
                            </label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                placeholder="Enter email address" 
                                value="{{ old('email', $user->email) }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Field (Optional) -->
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i> Password (Leave blank to keep current password)
                            </label>
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password" 
                                placeholder="Enter new password (optional)"
                            >
                            <small style="color: #7f8c8d;">If you want to change the password, enter a new one (min 8 characters)</small>
                            @error('password')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock"></i> Confirm Password
                            </label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                placeholder="Confirm new password (optional)"
                            >
                        </div>

                        <!-- Role Field -->
                        <div class="mb-3">
                            <label for="role" class="form-label">
                                <i class="fas fa-shield-alt"></i> Role
                            </label>
                            <select 
                                class="form-control @error('role') is-invalid @enderror" 
                                id="role" 
                                name="role" 
                                required
                            >
                                <option value="master_admin" @if(old('role', $user->role) === 'master_admin') selected @endif>Master Admin</option>
                                <option value="admin" @if(old('role', $user->role) === 'admin') selected @endif>Admin</option>
                                <option value="user" @if(old('role', $user->role) === 'user') selected @endif>User</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Field -->
                        <div class="mb-3">
                            <label for="status" class="form-label">
                                <i class="fas fa-check-circle"></i> Status
                            </label>
                            <select 
                                class="form-control @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required
                            >
                                <option value="active" @if(old('status', $user->status) === 'active') selected @endif>Active</option>
                                <option value="inactive" @if(old('status', $user->status) === 'inactive') selected @endif>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div style="display: flex; gap: 10px; margin-top: 30px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update User
                            </button>
                            <a href="{{ route('admins.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="col-lg-4">
            <div class="card" style="background: linear-gradient(135deg, #f093fb, #f5576c); color: white; border: none;">
                <div class="card-header" style="background: transparent; border: none; color: white;">
                    <i class="fas fa-info-circle"></i> Account Information
                </div>
                <div class="card-body" style="color: white;">
                    <ul style="margin-left: 0; padding-left: 20px; list-style: none;">
                        <li style="margin-bottom: 10px;">
                            <strong>Name:</strong> {{ $user->name }}
                        </li>
                        <li style="margin-bottom: 10px;">
                            <strong>Email:</strong> {{ $user->email }}
                        </li>
                        <li style="margin-bottom: 10px;">
                            <strong>Current Role:</strong>
                            @if($user->isMasterAdmin())
                                Master Admin
                            @elseif($user->isAdmin())
                                Admin
                            @else
                                User
                            @endif
                        </li>
                        <li style="margin-bottom: 10px;">
                            <strong>Current Status:</strong>
                            @if($user->isActive())
                                <span style="color: #d4edda;">Active</span>
                            @else
                                <span style="color: #f8d7da;">Inactive</span>
                            @endif
                        </li>
                        <li style="margin-bottom: 10px;">
                            <strong>Member Since:</strong> {{ $user->created_at->format('M d, Y') }}
                        </li>
                        <li>
                            <strong>Last Updated:</strong> {{ $user->updated_at->diffForHumans() }}
                        </li>
                    </ul>

                    @if($user->id === auth()->id())
                        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.3);">
                            <p style="font-size: 12px; margin: 0;">
                                <i class="fas fa-lock"></i> You cannot delete your own account
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
