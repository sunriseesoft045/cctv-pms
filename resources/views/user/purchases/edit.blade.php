@extends('user.layouts.app')
@section('page-title', 'Edit Purchase')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-edit"></i> Edit Purchase</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('user.purchases.index') }}" class="btn btn-secondary">
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
                    <h5 class="mb-0">Purchase #{{ $purchase->id }} Details</h5>
                </div>
                <div class="card-body">
                    @if($purchase->status !== 'pending')
                        <div class="alert alert-warning">
                            <strong>Note:</strong> This purchase has been {{ $purchase->status }}. You can only edit pending purchases.
                        </div>
                    @endif

                    <form action="{{ route('user.purchases.update', $purchase->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                            <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" {{ $purchase->status !== 'pending' ? 'disabled' : 'required' }}>
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ $purchase->product_id == $product->id ? 'selected' : '' }}>
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
                                   value="{{ old('quantity', $purchase->quantity) }}" min="1" {{ $purchase->status !== 'pending' ? 'disabled' : 'required' }}>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cost" class="form-label">Cost per Unit <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" name="cost" id="cost" class="form-control @error('cost') is-invalid @enderror" 
                                       value="{{ old('cost', $purchase->cost) }}" step="0.01" min="0.01" {{ $purchase->status !== 'pending' ? 'disabled' : 'required' }}>
                            </div>
                            @error('cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total Cost</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="text" id="total_cost" class="form-control" readonly value="{{ number_format($purchase->quantity * $purchase->cost, 2) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Status:</strong></p>
                                <p>
                                    @if($purchase->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending Approval</span>
                                    @elseif($purchase->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($purchase->status) }}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Created By:</strong></p>
                                <p>{{ $purchase->user->name }}</p>
                            </div>
                        </div>

                        <hr>

                        @if($purchase->status === 'pending')
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('user.purchases.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Purchase
                                </button>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Approved purchases cannot be edited. Please contact administrator if changes are needed.
                            </div>
                            <a href="{{ route('user.purchases.index') }}" class="btn btn-secondary">
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
    // Calculate total cost dynamically
    document.getElementById('quantity').addEventListener('input', calculateTotal);
    document.getElementById('cost').addEventListener('input', calculateTotal);

    function calculateTotal() {
        const quantity = parseFloat(document.getElementById('quantity').value) || 0;
        const cost = parseFloat(document.getElementById('cost').value) || 0;
        const total = (quantity * cost).toFixed(2);
        document.getElementById('total_cost').value = total;
    }

    // Initialize on page load
    calculateTotal();
</script>
@endsection