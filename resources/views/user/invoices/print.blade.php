<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff;
        }
        .container {
            width: 800px;
        }
        @media print {
            .btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-end mb-3">
            <button onclick="window.print()" class="btn btn-primary">Print</button>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h4>Invoice</h4>
                        <p><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</p>
                        <p><strong>Date:</strong> {{ $invoice->created_at->format('d M, Y') }}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <h4>Billed To</h4>
                        <p>{{ $invoice->customer_name }}</p>
                        @if($invoice->quotation)
                        <p>{{ $invoice->quotation->customer_address }}</p>
                        <p>{{ $invoice->quotation->customer_phone }}</p>
                        @endif
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ number_format($item->price, 2) }}</td>
                                <td>{{ number_format($item->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row justify-content-end mt-4">
                    <div class="col-md-4">
                        <table class="table table-sm">
                            <tr>
                                <th>Subtotal</th>
                                <td class="text-end">{{ number_format($invoice->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <th>GST (18%)</th>
                                <td class="text-end">{{ number_format($invoice->tax, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Grand Total</th>
                                <td class="text-end"><strong>{{ number_format($invoice->total, 2) }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
