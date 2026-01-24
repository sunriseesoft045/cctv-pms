@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-3">Bills of Materials (Recipes)</h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>BOMs</span>
            <a href="{{ route('admin.boms.create') }}" class="btn btn-primary">+ Create New BOM</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>SKU</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($boms as $bom)
                        <tr>
                            <td>{{ $bom->id }}</td>
                            <td>{{ $bom->name }}</td>
                            <td>{{ $bom->sku }}</td>
                            <td>{{ $bom->user->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.boms.show', $bom->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href='{{ route("admin.boms.edit", $bom) }}' class='btn btn-sm btn-primary'>Edit</a>
                                <form action='{{ route("admin.boms.destroy", $bom) }}' method='POST' style='display:inline'>
                                    @csrf
                                    @method('DELETE')
                                    <button class='btn btn-sm btn-danger' onclick='return confirm("Delete BOM?")'>
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No Bills of Materials found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection