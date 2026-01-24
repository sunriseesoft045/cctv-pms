@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-3">Assemblies</h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Assembly History</span>
            <a href="{{ route('admin.assemblies.create') }}" class="btn btn-primary">+ New Assembly</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Assembled</th>
                        <th>BOM Used</th>
                        <th>Quantity</th>
                        <th>Assembled By</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assemblies as $assembly)
                        <tr>
                            <td>{{ $assembly->id }}</td>
                            <td>{{ $assembly->product->name ?? 'N/A' }}</td>
                            <td>{{ $assembly->bom->name ?? 'N/A' }}</td>
                            <td>{{ $assembly->quantity }}</td>
                            <td>{{ $assembly->user->name ?? 'N/A' }}</td>
                            <td>{{ $assembly->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href='{{ route("admin.assemblies.edit", $assembly) }}' class='btn btn-sm btn-primary'>Edit</a>
                                <form action='{{ route("admin.assemblies.destroy", $assembly) }}' method='POST' style='display:inline'>
                                    @csrf
                                    @method('DELETE')
                                    <button class='btn btn-sm btn-danger' onclick='return confirm("Delete assembly?")'>Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No assembly records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $assemblies->links() }}
            </div>
        </div>
    </div>
</div>
@endsection