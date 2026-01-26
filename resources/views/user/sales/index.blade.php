@extends('user.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>User Sales</h3>
        <a href="{{ route('user.sales.create') }}" class="btn btn-primary">+ Add Sale</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->invoice_no }}</td>
                        <td>{{ $sale->customer->name }}</td>
                        <td>₹{{ number_format($sale->total_amount, 2) }}</td>
                        <td><span class="badge bg-primary">{{ ucwords($sale->status) }}</span></td>
                        <td>{{ $sale->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('user.sales.show', $sale->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('user.sales.edit', $sale->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('user.sales.destroy', $sale->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No sales found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection