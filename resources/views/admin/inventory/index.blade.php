@extends('admin.layouts.app')

@section('title', 'Inventory Stock Details')
@section('page-title', 'Inventory Stock Details')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1><i class="fas fa-warehouse"></i> Inventory Stock Details</h1>
        <p>Overview of current product stock levels</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="fas fa-list"></i> Product Stock
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Stock Left</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->stock }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No products found in inventory.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
