@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="page-header">
        <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
        <p>Welcome back, {{ auth()->user()->name }}! Here's your complete business overview.</p>
    </div>

    <!-- KPI Cards Row 1 -->
    <div class="row mb-4">
        <!-- Total Revenue -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #27ae60;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">TOTAL REVENUE</p>
                            <h3 class="mb-0" style="color: #27ae60; font-weight: 600;">Rs {{ number_format($totalSales, 2) }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(39, 174, 96, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-chart-line" style="color: #27ae60; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Cost -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #e74c3c;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">TOTAL COST</p>
                            <h3 class="mb-0" style="color: #e74c3c; font-weight: 600;">Rs {{ number_format($totalPurchases, 2) }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(231, 76, 60, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-shopping-cart" style="color: #e74c3c; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profit/Loss -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid {{ $profitLoss >= 0 ? '#3498db' : '#e74c3c' }};">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">PROFIT / LOSS</p>
                            <h3 class="mb-0" style="color: {{ $profitLoss >= 0 ? '#3498db' : '#e74c3c' }}; font-weight: 600;">Rs {{ number_format($profitLoss, 2) }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(52, 152, 219, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-balance-scale" style="color: {{ $profitLoss >= 0 ? '#3498db' : '#e74c3c' }}; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Payments -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #f39c12;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">TOTAL PAYMENTS</p>
                            <h3 class="mb-0" style="color: #f39c12; font-weight: 600;">Rs {{ number_format($totalPayments, 2) }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(243, 156, 18, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-money-bill-wave" style="color: #f39c12; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards Row 2 -->
    <div class="row mb-4">
        <!-- Total Stock -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #9b59b6;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">TOTAL STOCK</p>
                            <h3 class="mb-0" style="color: #9b59b6; font-weight: 600;">{{ $totalStock ?? 0 }} units</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(155, 89, 182, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-boxes" style="color: #9b59b6; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #e67e22;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">LOW STOCK ITEMS</p>
                            <h3 class="mb-0" style="color: #e67e22; font-weight: 600;">{{ $lowStockProducts ?? 0 }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(230, 126, 34, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-exclamation-triangle" style="color: #e67e22; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #1abc9c;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">TOTAL PRODUCTS</p>
                            <h3 class="mb-0" style="color: #1abc9c; font-weight: 600;">{{ $totalProducts ?? 0 }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(26, 188, 156, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-cube" style="color: #1abc9c; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #3498db;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">TOTAL USERS</p>
                            <h3 class="mb-0" style="color: #3498db; font-weight: 600;">{{ ($totalUsers ?? 0) + ($totalAdmins ?? 0) }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(52, 152, 219, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-users" style="color: #3498db; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Monthly Sales Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-chart-bar" style="color: #3498db;"></i> Monthly Sales Summary</h5>
                </div>
                <div class="card-body">
                    @if($monthlySales && count($monthlySales) > 0)
                        <div style="height: 300px;">
                            <canvas id="monthlySalesChart"></canvas>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line" style="font-size: 48px; color: #bdc3c7;"></i>
                            <p class="text-muted mt-2">No sales data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Low Stock Alerts -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-exclamation-circle" style="color: #e67e22;"></i> Low Inventory Alerts</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @if($lowStockAlerts && count($lowStockAlerts) > 0)
                        <div class="list-group list-group-flush">
                            @foreach($lowStockAlerts as $product)
                                <div class="list-group-item px-0 py-3 border-bottom">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $product->name }}</h6>
                                            <p class="mb-0 text-muted" style="font-size: 12px;">SKU: {{ $product->sku ?? 'N/A' }}</p>
                                        </div>
                                        <span class="badge {{ $product->stock < 3 ? 'bg-danger' : 'bg-warning' }}">
                                            {{ $product->stock }} units
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle" style="font-size: 48px; color: #27ae60;"></i>
                            <p class="text-muted mt-2">All inventory levels are healthy!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Sales -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-receipt" style="color: #27ae60;"></i> Recent Sales</h5>
                </div>
                <div class="card-body">
                    @if($recentSales && count($recentSales) > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="font-size: 12px;">Product</th>
                                        <th style="font-size: 12px;">Qty</th>
                                        <th style="font-size: 12px;">Amount</th>
                                        <th style="font-size: 12px;">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentSales as $sale)
                                        <tr>
                                            <td style="font-size: 12px;">{{ $sale->product->name ?? 'N/A' }}</td>
                                            <td style="font-size: 12px;">{{ $sale->quantity }}</td>
                                            <td style="font-size: 12px; color: #27ae60; font-weight: 500;">Rs {{ number_format($sale->quantity * $sale->price, 2) }}</td>
                                            <td style="font-size: 12px;">{{ $sale->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No recent sales</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-fire" style="color: #e74c3c;"></i> Top Selling Products</h5>
                </div>
                <div class="card-body">
                    @if($topProducts && count($topProducts) > 0)
                        <div class="list-group list-group-flush">
                            @foreach($topProducts as $item)
                                <div class="list-group-item px-0 py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $item->product->name ?? 'Unknown Product' }}</h6>
                                            <div style="width: 150px; height: 5px; background: #ecf0f1; border-radius: 3px; overflow: hidden;">
                                                <div style="width: {{ min(($item->total_quantity / 20) * 100, 100) }}%; height: 100%; background: linear-gradient(90deg, #3498db, #2980b9);"></div>
                                            </div>
                                        </div>
                                        <span class="badge bg-primary">{{ $item->total_quantity }} sold</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No sales data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-credit-card" style="color: #f39c12;"></i> Recent Payments</h5>
                </div>
                <div class="card-body">
                    @if($recentPayments && count($recentPayments) > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="font-size: 12px;">Payment ID</th>
                                        <th style="font-size: 12px;">Amount</th>
                                        <th style="font-size: 12px;">Method</th>
                                        <th style="font-size: 12px;">By</th>
                                        <th style="font-size: 12px;">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentPayments as $payment)
                                        <tr>
                                            <td style="font-size: 12px;">#{{ $payment->id }}</td>
                                            <td style="font-size: 12px; font-weight: 500;">Rs {{ number_format($payment->amount, 2) }}</td>
                                            <td style="font-size: 12px;">
                                                <span class="badge bg-info text-dark">{{ ucfirst($payment->payment_method ?? 'Unknown') }}</span>
                                            </td>
                                            <td style="font-size: 12px;">{{ $payment->user->name ?? 'N/A' }}</td>
                                            <td style="font-size: 12px;">{{ $payment->created_at->format('d M Y, H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No recent payments</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Monthly Sales Chart
        @if($monthlySales && count($monthlySales) > 0)
            const ctx = document.getElementById('monthlySalesChart').getContext('2d');
            const monthlySalesData = {!! json_encode($monthlySales) !!};
            
            // Reverse data to show oldest to newest
            monthlySalesData.reverse();
            
            const labels = monthlySalesData.map(item => {
                const [year, month] = item.month.split('-');
                const monthName = new Date(year, month - 1).toLocaleString('default', { month: 'short', year: 'numeric' });
                return monthName;
            });
            
            const data = monthlySalesData.map(item => parseFloat(item.total || 0));
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sales Amount (Rs)',
                        data: data,
                        backgroundColor: [
                            'rgba(52, 152, 219, 0.8)',
                            'rgba(46, 204, 113, 0.8)',
                            'rgba(155, 89, 182, 0.8)',
                            'rgba(230, 126, 34, 0.8)',
                            'rgba(231, 76, 60, 0.8)',
                            'rgba(52, 152, 219, 0.8)'
                        ],
                        borderColor: [
                            'rgba(52, 152, 219, 1)',
                            'rgba(46, 204, 113, 1)',
                            'rgba(155, 89, 182, 1)',
                            'rgba(230, 126, 34, 1)',
                            'rgba(231, 76, 60, 1)',
                            'rgba(52, 152, 219, 1)'
                        ],
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rs ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        @endif
    </script>
@endsection