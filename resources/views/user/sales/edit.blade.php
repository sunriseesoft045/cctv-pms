@extends('user.layouts.app')
@section('page-title', 'Edit Sale')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-edit"></i> Edit Sale</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('user.sales.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> Please fix the following errors:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Sale #{{ $sale->id }} Details</h5>
                </div>
                <div class="card-body">
                    @if($sale->status !== 'pending')
                        <div class="alert alert-warning">
                            <strong>Note:</strong> This sale has been {{ $sale->status }}. You can only edit pending sales.
                        </div>
                    @endif

                    <form action="{{ route('user.sales.update', $sale->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                            <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" {{ $sale->status !== 'pending' ? 'disabled' : 'required' }}>
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ $sale->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (SKU: {{ $product->sku }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                                   value="{{ old('quantity', $sale->quantity) }}" min="1" {{ $sale->status !== 'pending' ? 'disabled' : 'required' }}>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price per Unit <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" 
                                       value="{{ old('price', $sale->price) }}" step="0.01" min="0.01" {{ $sale->status !== 'pending' ? 'disabled' : 'required' }}>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total Price</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="text" id="total_price" class="form-control" readonly value="{{ number_format($sale->quantity * $sale->price, 2) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Status:</strong></p>
                                <p>
                                    @if($sale->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending Approval</span>
                                    @elseif($sale->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($sale->status) }}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Created By:</strong></p>
                                <p>{{ $sale->user->name }}</p>
                            </div>
                        </div>

                        <hr>

                        @if($sale->status === 'pending')
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('user.sales.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Sale
                                </button>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Approved sales cannot be edited. Please contact administrator if changes are needed.
                            </div>
                            <a href="{{ route('user.sales.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('quantity').addEventListener('input', calculateTotal);
    document.getElementById('price').addEventListener('input', calculateTotal);

    function calculateTotal() {
        const quantity = parseFloat(document.getElementById('quantity').value) || 0;
        const price = parseFloat(document.getElementById('price').value) || 0;
        const total = (quantity * price).toFixed(2);
        document.getElementById('total_price').value = total;
    }

    calculateTotal();
</script>
@endsection