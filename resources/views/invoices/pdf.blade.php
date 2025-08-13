<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .logo { height: 80px; }
        .company-info { text-align: right; font-size: 12px; }
        .invoice-title { text-align: center; margin: 20px 0; font-size: 24px; font-weight: bold; }
        .invoice-info { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .invoice-info td { padding: 5px 0; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items-table th { background-color: #f8f9fa; text-align: left; padding: 8px; border: 1px solid #ddd; }
        .items-table td { padding: 8px; border: 1px solid #ddd; }
        .total-table { width: 50%; float: right; border-collapse: collapse; }
        .total-table td { padding: 8px; border: 1px solid #ddd; }
        .footer { margin-top: 50px; font-size: 12px; text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            @if(file_exists(public_path('images/logo.png')))
            <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Company Logo">
            @endif
            <h1>emotions</h1>
            <h2>DESTINATION MANAGEMENT COMPANY</h2>
        </div>
        <div class="company-info">
            <p>7 kontynentów sp. z o.o</p>
            <p>ul. Grabowa 2, lokal 301</p>
            <p>40-172 - Katowice</p>
            <p>PL</p>
        </div>
    </div>

    <div class="invoice-title">Invoice #{{ $invoice->invoice_number }}</div>

    <table class="invoice-info">
        <tr>
            <td width="25%"><strong>VAT Number</strong></td>
            <td width="25%">PL 9542791623</td>
            <td width="25%"><strong>Issued</strong></td>
            <td width="25%">{{ $invoice->issue_date->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>File</strong></td>
            <td>{{ $invoice->file->reference }}</td>
            <td><strong>Expires</strong></td>
            <td>{{ $invoice->due_date ? $invoice->due_date->format('d/m/Y') : 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>Reference</strong></td>
            <td>{{ $invoice->file->reference }}</td>
            <td><strong>Currency</strong></td>
            <td>{{ $invoice->currency ? $invoice->currency->code : 'EUR' }}</td>
        </tr>
        <tr>
            <td><strong>Requested by</strong></td>
            <td>{{ $invoice->file->customer->name ?? 'N/A' }}</td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Service</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->service_name }}</td>
                <td>{{ $item->description ?? '-' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price, 2) }} {{ $item->currency ? $item->currency->code : 'EUR' }}</td>
                <td>{{ number_format($item->total_price, 2) }} {{ $item->currency ? $item->currency->code : 'EUR' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="total-table">
        <tr>
            <td class="text-bold">Subtotal:</td>
            <td class="text-right">{{ number_format($invoice->items->sum('total_price'), 2) }} {{ $invoice->currency ? $invoice->currency->code : 'EUR' }}</td>
        </tr>
        <tr>
            <td class="text-bold">Tax:</td>
            <td class="text-right">0,00 {{ $invoice->currency ? $invoice->currency->code : 'EUR' }}</td>
        </tr>
        <tr>
            <td class="text-bold">Total:</td>
            <td class="text-right">{{ number_format($invoice->total_amount, 2) }} {{ $invoice->currency ? $invoice->currency->code : 'EUR' }}</td>
        </tr>
    </table>

    <div style="clear: both;"></div>

    <div class="payment-details">
        <h3>Payment Details</h3>
        <p>Bank: BMCE BANK OF AFRICA</p>
        <p>IBAN: MAG4 0110 1000 0009 2100 0054 5605</p>
        <p>SWIFT: BMCEMAMC</p>
    </div>

    <div class="footer">
        <p>Incoming Emotions Morocco SARL</p>
        <p>N° 15, 4ème Etage, Inflasa 24 Station Hamra, Bd. Abderahim Bouashid | 80 033 | Agadir</p>
        <p>booking@emotions-morocco.com</p>
        <p>NIF ICE 002063529000062 | License ODV-1821</p>
    </div>
</body>
</html>