@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="page-header">
        <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
        <p>Welcome back, {{ auth()->user()->name }}! Here's your complete business overview.</p>
    </div>

    <!-- KPI Cards Row 1 (Financial Overview) -->
    <div class="row mb-4">
        <!-- Total Sales Amount -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #27ae60;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">TOTAL SALES</p>
                            <h3 class="mb-0" style="color: #27ae60; font-weight: 600;">Rs {{ number_format($totalSalesAmount ?? 0, 2) }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(39, 174, 96, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-chart-line" style="color: #27ae60; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Purchases Amount -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #e74c3c;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">TOTAL PURCHASES</p>
                            <h3 class="mb-0" style="color: #e74c3c; font-weight: 600;">Rs {{ number_format($totalPurchasesAmount ?? 0, 2) }}</h3>
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
            <div class="card border-0 shadow-sm" style="border-left: 4px solid {{ ($profitLoss ?? 0) >= 0 ? '#3498db' : '#e74c3c' }};">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">PROFIT / LOSS</p>
                            <h3 class="mb-0" style="color: {{ ($profitLoss ?? 0) >= 0 ? '#3498db' : '#e74c3c' }}; font-weight: 600;">Rs {{ number_format($profitLoss ?? 0, 2) }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(52, 152, 219, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-balance-scale" style="color: {{ ($profitLoss ?? 0) >= 0 ? '#3498db' : '#e74c3c' }}; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Payments Received -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #f39c12;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">PAYMENTS RECEIVED</p>
                            <h3 class="mb-0" style="color: #f39c12; font-weight: 600;">Rs {{ number_format($totalPaymentsReceived ?? 0, 2) }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(243, 156, 18, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-money-bill-wave" style="color: #f39c12; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards Row 2 (Inventory & Dues) -->
    <div class="row mb-4">
        <!-- Total Inventory Stock (Parts + Finished Products) -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #9b59b6;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">TOTAL INVENTORY STOCK</p>
                            <h3 class="mb-0" style="color: #9b59b6; font-weight: 600;">{{ $totalInventoryStock ?? 0 }} units</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(155, 89, 182, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-boxes" style="color: #9b59b6; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Items Count -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #e67e22;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">LOW STOCK PARTS</p>
                            <h3 class="mb-0" style="color: #e67e22; font-weight: 600;">{{ $lowStockPartsCount ?? 0 }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(230, 126, 34, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-exclamation-triangle" style="color: #e67e22; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Dues (Customers + Vendors) -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #f1c40f;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">TOTAL DUES</p>
                            <h3 class="mb-0" style="color: #f1c40f; font-weight: 600;">Rs {{ number_format($totalDues ?? 0, 2) }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(241, 196, 15, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-hand-holding-usd" style="color: #f1c40f; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Sales (Current Month) -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #1abc9c;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1" style="font-size: 13px;">SALES THIS MONTH</p>
                            <h3 class="mb-0" style="color: #1abc9c; font-weight: 600;">Rs {{ number_format($currentMonthSales ?? 0, 2) }}</h3>
                        </div>
                        <div style="width: 50px; height: 50px; background: rgba(26, 188, 156, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-alt" style="color: #1abc9c; font-size: 24px;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables -->
    <div class="row">
        <!-- Monthly Sales Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="fas fa-chart-bar" style="color: #3498db;"></i> Monthly Sales Summary</h5>
                </div>
                <div class="card-body">
                    @if(isset($monthlySales) && count($monthlySales) > 0)
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
                    @if(isset($lowStockAlerts) && count($lowStockAlerts) > 0)
                        <div class="list-group list-group-flush">
                            @foreach($lowStockAlerts as $product)
                                <div class="list-group-item px-0 py-3 border-bottom">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $product->name }}</h6>
                                            <p class="mb-0 text-muted" style="font-size: 12px;">SKU: {{ $product->sku ?? 'N/A' }}</p>
                                        </div>
                                        <span class="badge {{ $product->stock < $product->min_stock ? 'bg-danger' : 'bg-warning' }}">
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

    <!-- Other existing content (Recent Sales, Top Selling Products, Recent Payments) can be kept or removed as needed -->
    <!-- For simplicity, I will remove them as the new dashboard focuses on key analytics -->
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Monthly Sales Chart
        @if(isset($monthlySales) && count($monthlySales) > 0)
            const ctx = document.getElementById('monthlySalesChart').getContext('2d');
            const monthlySalesData = {!! json_encode($monthlySales) !!};
            
            // Reverse data to show oldest to newest
            // monthlySalesData.reverse();
            
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