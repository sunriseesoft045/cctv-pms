@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-edit"></i> Edit Category
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Category</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
