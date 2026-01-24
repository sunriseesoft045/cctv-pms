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
        @forelse($purchases as $p)
        <tr>
          <td>{{ $p->id }}</td>
          <td>{{ $p->vendor->name ?? 'N/A' }}</td>
          <td>₹{{ number_format($p->total_amount,2) }}</td>
          <td>{{ $p->created_at->format('d M Y') }}</td>
          <td>
            <a href='{{ route("user.purchases.show",$p->id) }}' class='btn btn-sm btn-info'>View</a>
            <a href='{{ route("user.purchases.edit",$p->id) }}' class='btn btn-sm btn-warning'>Edit</a>
            <form action='{{ route("user.purchases.destroy",$p->id) }}' method='POST' class='d-inline'>
              @csrf
              @method('DELETE')
              <button class='btn btn-sm btn-danger'>Delete</button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan='5' class='text-center'>No purchases found</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

</div>
@endsection