@extends('user.layouts.app')
@section('page-title', 'Sales')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-chart-line"></i> Sales</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('user.sales.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Sale
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">All Sales</h5>
        </div>
        <div class="card-body">
            @if($sales->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price/Unit</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    <td>#{{ $sale->id }}</td>
                                    <td>
                                        <strong>{{ $sale->product->name }}</strong><br>
                                        <small class="text-muted">SKU: {{ $sale->product->sku }}</small>
                                    </td>
                                    <td>{{ $sale->quantity }}</td>
                                    <td>₹{{ number_format($sale->price, 2) }}</td>
                                    <td><strong>₹{{ number_format($sale->quantity * $sale->price, 2) }}</strong></td>
                                    <td>
                                        @if($sale->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($sale->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($sale->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $sale->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            @if($sale->status === 'pending')
                                                <a href="{{ route('user.sales.edit', $sale->id) }}" 
                                                   class="btn btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('user.sales.destroy', $sale->id) }}" 
                                                      method="POST" style="display:inline;" 
                                                      onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted small">No actions available</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    {{ $sales->links() }}
                </nav>
            @else
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i> No sales found. 
                    <a href="{{ route('user.sales.create') }}">Create your first sale</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection