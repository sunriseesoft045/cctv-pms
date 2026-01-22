@extends('admin.layouts.app')

@section('title', 'Units')
@section('page-title', 'Units')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-ruler-combined"></i> Units</h1>
        <a href="{{ route('admin.units.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Unit
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> All Units
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
                @forelse($units as $unit)
                <tr>
                    <td>{{ $unit->name }}</td>
                    <td>
                        <a href="{{ route('admin.units.edit', $unit->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this unit?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">No units found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $units->links() }}
        </div>
    </div>
</div>
@endsection
