@extends('user.layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">User Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Purchases</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalPurchases }}</h5>
                    <a href="{{ route('user.purchases.index') }}" class="text-white">View Details <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Sales</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalSales }}</h5>
                    <a href="{{ route('user.sales.index') }}" class="text-white">View Details <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Total Payments</div>
                <div class="card-body">
                    <h5 class="card-title">₹{{ number_format($totalPayments, 2) }}</h5>
                    <a href="{{ route('user.payments.index') }}" class="text-white">View Details <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
