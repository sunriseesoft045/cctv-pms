@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3>BOM Details</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Product Name:</strong> {{ $bom->name }}
                </div>
                <div class="col-md-6">
                    <strong>SKU:</strong> {{ $bom->sku }}
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <strong>Created By:</strong> {{ $bom->user->name ?? 'N/A' }}
                </div>
                <div class="col-md-6">
                    <strong>Created At:</strong> {{ $bom->created_at->format('Y-m-d H:i') }}
                </div>
            </div>

            <h4>Required Parts (Recipe)</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Part Name</th>
                        <th>Part SKU</th>
                        <th>Quantity Required</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bom->items as $item)
                        <tr>
                            <td>{{ $item->part->name }}</td>
                            <td>{{ $item->part->sku }}</td>
                            <td>{{ $item->qty_required }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('admin.boms.index') }}" class="btn btn-secondary mt-3">Back to List</a>
        </div>
    </div>
</div>
@endsection