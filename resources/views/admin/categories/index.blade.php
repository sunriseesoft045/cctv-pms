@extends('admin.layouts.app')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-tags"></i> Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Category
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> All Categories
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">No categories found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
