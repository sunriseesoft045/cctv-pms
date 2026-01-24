@extends('admin.layouts.app')

@section('content')
<div class='container-fluid'>

<h1 class='mb-3'>Inventory Report</h1>

<h4>Parts Stock</h4>
<table class='table table-bordered'>
<thead>
<tr>
  <th>Name</th>
  <th>SKU</th>
  <th>Unit</th>
  <th>Stock</th>
  <th>Min</th>
</tr>
</thead>
<tbody>
@foreach($parts as $p)
<tr @if($p->stock <= $p->min_stock) class='table-danger' @endif>
  <td>{{ $p->name }}</td>
  <td>{{ $p->sku }}</td>
  <td>{{ $p->unit }}</td>
  <td>{{ $p->stock }}</td>
  <td>{{ $p->min_stock }}</td>
</tr>
@endforeach
</tbody>
</table>

<h4 class='mt-4'>Finished Products</h4>
<table class='table table-bordered'>
<thead>
<tr>
  <th>Name</th>
  <th>SKU</th>
  <th>Stock</th>
</tr>
</thead>
<tbody>
@foreach($finished as $f)
<tr>
  <td>{{ $f->name }}</td>
  <td>{{ $f->sku }}</td>
  <td>{{ $f->stock }}</td>
</tr>
@endforeach
</tbody>
</table>

</div>
@endsection