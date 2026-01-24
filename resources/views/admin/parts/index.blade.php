@extends('admin.layouts.app')

@section('content')
<h1>Admin Parts List</h1>
<p>List of parts and their stock levels. Highlight if stock <= min_stock.</p>

<a href='{{ route("admin.parts.create") }}' class='btn btn-success mb-3'>
+ Add Part
</a>

<table class='table table-bordered'>
    <thead>
        <tr>
            <th>Name</th>
            <th>SKU</th>
            <th>Unit</th>
            <th>Stock</th>
            <th>Min</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($parts as $part)
            <tr @if($part->stock <= $part->min_stock) class='table-danger' @endif>
                <td>{{ $part->name }}</td>
                <td>{{ $part->sku }}</td>
                <td>{{ $part->unit }}</td>
                <td>{{ $part->stock }}</td>
                <td>{{ $part->min_stock }}</td>
                <td>
                    <a href='{{ route("admin.parts.edit", $part) }}' class='btn btn-sm btn-primary'>Edit</a>
                    <form action='{{ route("admin.parts.destroy", $part) }}' method='POST' style='display:inline'>
                        @csrf
                        @method('DELETE')
                        <button class='btn btn-sm btn-danger' onclick='return confirm("Delete this part?")'>
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
