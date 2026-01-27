<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06f;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .invoice-box table td.text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <!-- <img src="logo.png" style="width:100%; max-width:300px;"> -->
                                Company Name
                            </td>
                            <td>
                                Invoice #: {{ $invoice->invoice_number }}<br>
                                Created: {{ $invoice->date->format('M d, Y') }}<br>
                                Due: {{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                Bill To:<br>
                                {{ $invoice->bill_to }}<br>
                                @if($invoice->ship_to)
                                Ship To:<br>
                                {{ $invoice->ship_to }}
                                @endif
                            </td>
                            <td>
                                Payment Terms: {{ $invoice->payment_terms }}<br>
                                PO Number: {{ $invoice->po_number }}<br>
                                Status: {{ ucfirst($invoice->status) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Item</td>
                <td class="text-right">Quantity</td>
                <td class="text-right">Rate</td>
                <td class="text-right">Amount</td>
            </tr>

            @foreach ($invoice->items as $item)
            <tr class="item">
                <td>{{ $item->item_name }}</td>
                <td class="text-right">{{ $item->quantity }}</td>
                <td class="text-right">{{ number_format($item->rate, 2) }}</td>
                <td class="text-right">{{ number_format($item->amount, 2) }}</td>
            </tr>
            @endforeach

            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right">
                   Subtotal: {{ number_format($invoice->subtotal, 2) }}
                </td>
            </tr>
            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right">
                    Tax: {{ number_format($invoice->tax, 2) }}
                </td>
            </tr>
             <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right">
                    Discount: {{ number_format($invoice->discount, 2) }}
                </td>
            </tr>
            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right">
                    Shipping: {{ number_format($invoice->shipping, 2) }}
                </td>
            </tr>
            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right">
                   Total: {{ number_format($invoice->total, 2) }}
                </td>
            </tr>
            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right">
                   Paid: {{ number_format($invoice->paid, 2) }}
                </td>
            </tr>
            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right">
                   Balance Due: {{ number_format($invoice->balance, 2) }}
                </td>
            </tr>
        </table>

        @if($invoice->notes)
        <div class="mt-4" style="border-top: 1px solid #eee; padding-top: 10px;">
            <h4>Notes:</h4>
            <p>{{ $invoice->notes }}</p>
        </div>
        @endif

        @if($invoice->terms)
        <div class="mt-4" style="border-top: 1px solid #eee; padding-top: 10px;">
            <h4>Terms & Conditions:</h4>
            <p>{{ $invoice->terms }}</p>
        </div>
        @endif
    </div>
</body>
</html>
