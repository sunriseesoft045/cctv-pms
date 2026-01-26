@extends('user.layouts.app')

@section('content')
<div class='container-fluid'>

<div class='d-flex justify-content-between align-items-center mb-3'>
  <h3>User Purchases</h3>
  <a href='{{ route("user.purchases.create") }}' class='btn btn-primary'>
    + Add Purchase
  </a>
</div>

<div class='card'>
  <div class='card-body'>
    <table class='table table-bordered table-striped'>
      <thead>
        <tr>
          <th>#</th>
          <th>Vendor</th>
          <th>Total Amount</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($purchases as $purchase)
        <tr>
          <td>{{ $purchase->id }}</td>

          <td>{{ $purchase->vendor->name ?? 'N/A' }}</td>

          <td>₹{{ number_format($purchase->total_amount,2) }}</td>

          <td>{{ $purchase->created_at->format('d M Y') }}</td>

          <td>
            <a href="{{ route('user.purchases.show',$purchase->id) }}" class="btn btn-info btn-sm">View</a>
            <a href="{{ route('user.purchases.edit',$purchase->id) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('user.purchases.destroy',$purchase->id) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this purchase?')">
                Delete
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

</div>
@endsection