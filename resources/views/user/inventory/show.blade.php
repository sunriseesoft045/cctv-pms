@extends('user.layouts.app')

@section('page-title', 'Inventory Item Details')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Inventory Item Details</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>{{ $product->name }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>SKU:</strong> {{ $product->sku }}</p>
                    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    <p><strong>Stock:</strong> {{ $product->stock }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('user.inventory.index') }}" class="btn btn-secondary">Back to Inventory</a>
            <a href="{{ route('user.inventory.edit', $product->id) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
</div>
@endsection
