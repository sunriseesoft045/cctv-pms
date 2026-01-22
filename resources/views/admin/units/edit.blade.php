@extends('admin.layouts.app')

@section('title', 'Edit Unit')
@section('page-title', 'Edit Unit')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-edit"></i> Edit Unit
    </div>
    <div class="card-body">
        <form action="{{ route('admin.units.update', $unit->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Unit Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $unit->name) }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Unit</button>
            <a href="{{ route('admin.units.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
