@extends('admin.layouts.app')

@section('title', 'Approvals Management')
@section('page-title', 'Approvals Management')

@section('content')
    <div class="page-header">
        <h1><i class="fas fa-check-double"></i> Approvals Management</h1>
        <p>Review and approve pending purchases and sales</p>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="approvalTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="purchases-tab" data-bs-toggle="tab" href="#pendingPurchases" role="tab" aria-controls="pendingPurchases" aria-selected="true">
                                <i class="fas fa-shopping-cart"></i> Pending Purchases ({{ $pendingPurchases->total() }})
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sales-tab" data-bs-toggle="tab" href="#pendingSales" role="tab" aria-controls="pendingSales" aria-selected="false">
                                <i class="fas fa-hand-holding-usd"></i> Pending Sales ({{ $pendingSales->total() }})
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="approvalTabsContent">
                        {{-- Pending Purchases Tab --}}
                        <div class="tab-pane fade show active" id="pendingPurchases" role="tabpanel" aria-labelledby="purchases-tab">
                            @if($pendingPurchases->isEmpty())
                                <div class="alert alert-info text-center" role="alert">
                                    <i class="fas fa-info-circle"></i> No pending purchases to approve.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User</th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Total Cost</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingPurchases as $purchase)
                                                <tr>
                                                    <td>{{ $purchase->id }}</td>
                                                    <td>{{ $purchase->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $purchase->product->name ?? 'N/A' }}</td>
                                                    <td>{{ $purchase->quantity }}</td>
                                                    <td>{{ number_format($purchase->cost * $purchase->quantity, 2) }}</td>
                                                    <td>{{ $purchase->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <form action="{{ route('admin.approvals.purchase.approve', $purchase->id) }}" method="POST" style="display: inline-block;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                        </form>
                                                        <form action="{{ route('admin.approvals.purchase.reject', $purchase->id) }}" method="POST" style="display: inline-block; margin-left: 5px;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center">
                                    {{ $pendingPurchases->links() }}
                                </div>
                            @endif
                        </div>

                        {{-- Pending Sales Tab --}}
                        <div class="tab-pane fade" id="pendingSales" role="tabpanel" aria-labelledby="sales-tab">
                            @if($pendingSales->isEmpty())
                                <div class="alert alert-info text-center" role="alert">
                                    <i class="fas fa-info-circle"></i> No pending sales to approve.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User</th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Total Price</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingSales as $sale)
                                                <tr>
                                                    <td>{{ $sale->id }}</td>
                                                    <td>{{ $sale->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $sale->product->name ?? 'N/A' }}</td>
                                                    <td>{{ $sale->quantity }}</td>
                                                    <td>{{ number_format($sale->price * $sale->quantity, 2) }}</td>
                                                    <td>{{ $sale->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <form action="{{ route('admin.approvals.sale.approve', $sale->id) }}" method="POST" style="display: inline-block;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                        </form>
                                                        <form action="{{ route('admin.approvals.sale.reject', $sale->id) }}" method="POST" style="display: inline-block; margin-left: 5px;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center">
                                    {{ $pendingSales->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
