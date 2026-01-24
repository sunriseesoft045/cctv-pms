
<!DOCTYPE html>
<html>
<head>
    <title>{{  ?? 'Purchase Invoice' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        .container { padding: 20px; }
        .header, .footer { text-align: center; margin-bottom: 20px; }
        .details, .items { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .details th, .details td, .items th, .items td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .items th { background-color: #f2f2f2; }
        .total { text-align: right; margin-top: 20px; }
        .total td { padding: 5px 8px; border: 1px solid #ddd; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>{{ ->name ?? 'Your Company Name' }}</h2>
            <p>{{ ->address ?? 'Company Address' }}</p>
            <p>GST No: {{ ->gst_no ?? 'N/A' }}</p>
        </div>

        <h3 style='text-align: center;'>{{  ?? 'Invoice' }} #{{ ->invoice_no }}</h3>

        <table class='details'>
            <tr>
                <th>Invoice No:</th><td>{{ ->invoice_no }}</td>
                <th>Date:</th><td>{{ ->created_at->format('d M Y') }}</td>
            </tr>
            <tr>
                <th>Vendor Name:</th><td>{{ ->name ?? 'N/A' }}</td>
                <th>Vendor Email:</th><td>{{ ->email ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Vendor Phone:</th><td>{{ ->phone ?? 'N/A' }}</td>
                <th>Vendor Address:</th><td>{{ ->address ?? 'N/A' }}</td>
            </tr>
        </table>

        <h4>Items</h4>
        <table class='items'>
            <thead>
                <tr>
                    <th>Part</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach(->items as )
                <tr>
                    <td>{{ ->part->name ?? 'N/A' }}</td>
                    <td>{{ ->quantity }}</td>
                    <td>Rs {{ number_format(->price, 2) }}</td>
                    <td>Rs {{ number_format(->quantity * ->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class='total'>
            <tr><td class='text-right'><strong>Total Amount:</strong></td><td><strong>Rs {{ number_format(->total_amount, 2) }}</strong></td></tr>
            <tr><td class='text-right'>Amount Paid:</td><td>Rs {{ number_format(->amount_paid, 2) }}</td></tr>
            <tr><td class='text-right'>Amount Due:</td><td>Rs {{ number_format(->amount_due, 2) }}</td></tr>
            <tr><td class='text-right'>Payment Status:</td><td>{{ ucfirst(->status) }}</td></tr>
        </table>

        <div class='footer'>
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>

