@extends('layouts.app')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fas fa-box-open"></i> All Products
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                    <td>{{ $product->unit->name ?? 'N/A' }}</td>
                    <td>{{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
