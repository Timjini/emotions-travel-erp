<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Proforma Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            margin-bottom: 30px;
        }

        .logo_image {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            height: 200px;
            width: auto;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .address {
            position: absolute;
            line-height: 1.4;
            margin-bottom: 30px;
            right: 20px;
            top: 150px;
        }

        .invoice-number {
            font-weight: bold;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.details {
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .payment-details {
            margin-bottom: 30px;
            border: 1px solid #c0c0c0;
            padding: 5px;
        }

        .payment-details p {
            margin: 5px 0;
        }

        .totals {
            width: 250px;
            padding: 5px;
            margin-bottom: 30px;
        }

        .payment-container {
            width: 100%;
            margin-bottom: 20px;
        }

        .payment-details,
        .totals {
            display: inline-block;
            vertical-align: top;
        }

        .payment-details {
            width: 50%;
        }

        .totals {
            padding-left: 50px;
            width: 38%;
        }

        .total-container {
            width: 100%;
            padding: 5px 0;
        }

        .total-container p {
            display: inline-block;
            width: 48%;
            margin: 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    @php $companySetting = Auth::user()->company->setting ?? null; $company
    = Auth::user()->company ?? null; $customer = $invoice->file->customer ??
    null; @endphp
    <div class="header">
        <div class="logo">
            <img
                src="https://pub-56989421c96a4a83a6c1e963a31939e6.r2.dev/emotions-travel/emotions-morocco-logo%20(1).webp"
                class="logo_image" />
        </div>
        <div class="address">
            {{$invoice->file->customer->address}}<br />
            {{$invoice->file->customer->post_code}}<br />
            {{$invoice->file->customer->city}}<br />
            {{$invoice->file->customer->country}}
        </div>
    </div>

    <div class="invoice-number">Proforma n°: {{$invoice->file->reference}}</div>

<table class="details">
    <tr>
        <th>File</th>
        <th>Reference</th>
        <th>Service</th>
        <th>Requested by</th>
    </tr>
    <tr>
        <td>{{ $invoice->file_number ?? '149/2025' }}</td>
        <td>{{ $invoice->reference ?? 'Morocco Grand Tour' }}</td>
        <td>{{ $invoice->service_date ? \Carbon\Carbon::parse($invoice->service_date)->format('d/m/Y') : '27/09/2025' }}</td>
        <td>{{ $invoice->requested_by ?? 'Paulina' }}</td>
    </tr>
</table>

<table>
    <tr>
        <th>Tax</th>
        <th>Description</th>
        <th>Qty</th>
        <th>Amount</th>
        <th>Total</th>
    </tr>
    <tr>
        <td>{{ $invoice->tax_rate ?? '' }}</td>
        <td>{{ $invoice->description ?? 'Morocco Tour 27.09.2025-05.10.2025' }}</td>
        <td>{{ $invoice->quantity ?? 6 }}</td>
        <td>{{ number_format($invoice->unit_price ?? 1110, 2, ',', '.') }} {{ $invoice->currency->code ?? 'EUR' }}</td>
        <td>{{ number_format($invoice->total_amount ?? 6660, 2, ',', '.') }} {{ $invoice->currency->code ?? 'EUR' }}</td>
    </tr>
</table>

    <div class="payment-container">
        <div class="payment-details">
            <p><strong>Payment Details</strong></p>
            <p>Bank: {{$company->setting->bank_name}}</p>
            <p>Iban: {{$company->setting->iban}}</p>
            <p>Swift: {{$company->setting->swift}}</p>
        </div>

        <table class="total-table">
        <tr>
            <td class="label">Subtotal:</td>
            <td class="text-right">{{ number_format($invoice->items->sum('total_price'), 2) }} {{ $invoice->currency->code ?? ($companySetting->invoice_currency ?? 'EUR') }}</td>
        </tr>
        <tr>
            <td class="label">Tax (0%):</td>
            <td class="text-right">0.00 {{ $invoice->currency->code ?? ($companySetting->invoice_currency ?? 'EUR') }}</td>
        </tr>
        <tr>
            <td class="label total-row">TOTAL DUE:</td>
            <td class="text-right total-row">{{ number_format($invoice->total_amount, 2) }} {{ $invoice->currency->code ?? ($companySetting->invoice_currency ?? 'EUR') }}</td>
        </tr>
    </table>
    </div>
    <hr />
    <div class="footer">
        <div class="total-container">
            <p>{{$company->name}}</p>
        </div>

        <div class="total-container">
            <p>
                {{$company->address}}
            </p>
        </div>
        <div class="total-container">
            <p>{{$company->email}}</p>
        </div>
        <div class="total-container">
            <p>{{$company->vat_number}}</p>
        </div>
    </div>
</body>

</html>