@extends('admin.layouts.app')

@section('title', 'Create User')
@section('page-title', 'Create New User')

@section('content')
    <div class="page-header">
        <h1><i class="fas fa-user-plus"></i> Create New User</h1>
        <p>Add a new user account to the system</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-check"></i> User Information
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.admins.store') }}" method="POST">
                        @csrf

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
                                value="{{ old('name') }}"
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
                                value="{{ old('email') }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock"></i> Password
                            </label>
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password" 
                                placeholder="Enter password (min 8 characters)" 
                                required
                            >
                            <small style="color: #7f8c8d;">Password must be at least 8 characters long</small>
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
                                placeholder="Confirm password" 
                                required
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
                                <option value="">Select a role</option>
                                <option value="admin" @if(old('role') === 'admin') selected @endif>Admin</option>
                                <option value="user" @if(old('role') === 'user') selected @endif>User</option>
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
                                <option value="active" @if(old('status') === 'active') selected @endif>Active</option>
                                <option value="inactive" @if(old('status') === 'inactive') selected @endif>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div style="display: flex; gap: 10px; margin-top: 30px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create User
                            </button>
                            <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="col-lg-4">
            <div class="card" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none;">
                <div class="card-header" style="background: transparent; border: none; color: white;">
                    <i class="fas fa-info-circle"></i> Information
                </div>
                <div class="card-body" style="color: white;">
                    <h6 style="margin-top: 15px; color: white;">User Roles:</h6>
                    <ul style="margin-left: 0; padding-left: 20px;">
                        <li><strong>Master Admin:</strong> Full system access and management</li>
                        <li><strong>Admin:</strong> Full access to admin panel</li>
                        <li><strong>User:</strong> Limited access to view reports only</li>
                    </ul>

                    <h6 style="margin-top: 15px; color: white;">Password Requirements:</h6>
                    <ul style="margin-left: 0; padding-left: 20px; font-size: 14px;">
                        <li>Minimum 8 characters</li>
                        <li>Mix of uppercase and lowercase</li>
                        <li>Include numbers and special characters</li>
                    </ul>

                    <h6 style="margin-top: 15px; color: white;">Account Status:</h6>
                    <p style="font-size: 14px; margin-bottom: 0;">
                        Active accounts can login to the system. Inactive accounts will be locked.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
