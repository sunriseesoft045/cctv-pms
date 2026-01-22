@extends('admin.layouts.app')

@section('title', 'Reports')
@section('page-title', 'Reports')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1><i class="fas fa-chart-bar"></i> Reports</h1>
        <p>Live data overview of system activities</p>
    </div>
</div>

<!-- Statistics Row -->
<div class="row" style="margin-bottom: 30px;">
    <!-- Total Users Card -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-title">Total Users</div>
            <div class="stat-card-value">{{ $reports['totalUsers'] }}</div>
        </div>
    </div>

    <!-- Total Admins Card -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-card-title">Total Admins</div>
            <div class="stat-card-value">{{ $reports['totalAdmins'] }}</div>
        </div>
    </div>

    <!-- Total Sales Card -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                <i class="fas fa-cart-plus"></i>
            </div>
            <div class="stat-card-title">Total Sales</div>
            <div class="stat-card-value">{{ $reports['totalSales'] }}</div>
        </div>
    </div>

    <!-- Total Purchases Card -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #f8cdda, #1d2b64);">
                <i class="fas fa-dolly-flatbed"></i>
            </div>
            <div class="stat-card-title">Total Purchases</div>
            <div class="stat-card-value">{{ $reports['totalPurchases'] }}</div>
        </div>
    </div>
    
    <!-- Total Payments Card -->
    <div class="col-md-12" style="margin-top: 20px;">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: linear-gradient(135deg, #ff9a9e, #fad0c4);">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-card-title">Total Payments Received</div>
            <div class="stat-card-value">Rs {{ number_format($reports['totalPayments'], 2) }}</div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Latest Sales Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list"></i> Latest Sales
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>User</th>
                            <th>Price</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports['latestSales'] as $sale)
                            <tr>
                                <td>{{ $sale->product->name ?? 'N/A' }}</td>
                                <td>{{ $sale->user->name ?? 'N/A' }}</td>
                                <td>Rs {{ number_format($sale->price, 2) }}</td>
                                <td>{{ $sale->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No sales data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Latest Purchases Table -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list"></i> Latest Purchases
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>User</th>
                            <th>Cost</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports['latestPurchases'] as $purchase)
                            <tr>
                                <td>{{ $purchase->product->name ?? 'N/A' }}</td>
                                <td>{{ $purchase->user->name ?? 'N/A' }}</td>
                                <td>Rs {{ number_format($purchase->cost, 2) }}</td>
                                <td>{{ $purchase->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No purchase data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection