@extends('admin.layouts.app')

@section('title', 'Admin Management')
@section('page-title', 'Admin Management')

@section('content')
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1><i class="fas fa-users-cog"></i> Admin Management</h1>
            <p>Manage all system administrators and their permissions</p>
        </div>
        <a href="{{ route('admins.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Add New Admin
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="card" style="margin-bottom: 20px;">
        <div class="card-body">
            <form action="{{ route('admins.index') }}" method="GET" class="row g-3">
                <div class="col-md-6">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search by name or email..." 
                        value="{{ request('search') }}"
                    >
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="active" @if(request('status') === 'active') selected @endif>Active</option>
                        <option value="inactive" @if(request('status') === 'inactive') selected @endif>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-list"></i> All Users ({{ $users->total() }})
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <strong>{{ $user->name }}</strong>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->isMasterAdmin())
                                    <span class="badge badge-master">Master Admin</span>
                                @elseif($user->isAdmin())
                                    <span class="badge badge-admin">Admin</span>
                                @else
                                    <span class="badge badge-user">User</span>
                                @endif
                            </td>
                            <td>
                                @if($user->isActive())
                                    <span class="badge badge-active">Active</span>
                                @else
                                    <span class="badge badge-inactive">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a 
                                        href="{{ route('admins.edit', $user->id) }}" 
                                        class="btn btn-sm" 
                                        style="background: #3498db; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; transition: all 0.3s ease;"
                                        onmouseover="this.style.background='#2980b9'"
                                        onmouseout="this.style.background='#3498db'"
                                    >
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admins.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="btn btn-sm" 
                                                style="background: #e74c3c; color: white; padding: 6px 12px; border-radius: 4px; border: none; cursor: pointer; font-size: 12px; transition: all 0.3s ease;"
                                                onmouseover="this.style.background='#c0392b'"
                                                onmouseout="this.style.background='#e74c3c'"
                                            >
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px 20px;">
                                <i class="fas fa-inbox" style="font-size: 32px; color: #bdc3c7; margin-bottom: 10px; display: block;"></i>
                                <strong>No users found</strong>
                                <p style="color: #7f8c8d; margin-top: 5px;">Start by creating a new user account</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div style="padding: 20px;">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
