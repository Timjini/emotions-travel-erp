<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        @page { margin: 50px 40px; }
        body { 
            font-family: 'DejaVu Sans', Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            font-size: 12px;
        }
        .header { 
            display: flex; 
            justify-content: space-between; 
            margin-bottom: 30px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 20px;
        }
        .logo { 
            height: 70px;
            margin-bottom: 10px;
        }
        .company-info { 
            text-align: right;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 5px;
        }
        .invoice-title { 
            text-align: center; 
            margin: 20px 0 30px; 
            font-size: 24px; 
            font-weight: bold;
            color: #1e40af;
        }
        .invoice-info { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 30px;
        }
        .invoice-info td { 
            padding: 8px 0;
            vertical-align: top;
        }
        .invoice-info .label {
            font-weight: 600;
            color: #4b5563;
            width: 25%;
        }
        .items-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px;
            font-size: 11px;
        }
        .items-table th { 
            background-color: #1e40af;
            color: white;
            text-align: left; 
            padding: 10px 8px; 
            border: 1px solid #e5e7eb;
            font-weight: 600;
        }
        .items-table td { 
            padding: 10px 8px; 
            border: 1px solid #e5e7eb;
            vertical-align: top;
        }
        .items-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .total-table { 
            width: 250px; 
            float: right; 
            border-collapse: collapse;
            margin-top: 10px;
        }
        .total-table td { 
            padding: 12px 15px; 
            border: 1px solid #e5e7eb;
        }
        .total-table .label {
            font-weight: 600;
            background-color: #f3f4f6;
        }
        .total-table .total-row {
            font-weight: bold;
            background-color: #f3f4f6;
            font-size: 13px;
        }
        .footer { 
            margin-top: 50px; 
            font-size: 10px; 
            text-align: center;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
        .text-right { 
            text-align: right; 
        }
        .text-bold { 
            font-weight: bold; 
        }
        .payment-details {
            margin-top: 30px;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }
        .payment-details h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 14px;
            color: #1e40af;
        }
        .clear {
            clear: both;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            background-color: #1e40af;
            color: white;
        }
    </style>
</head>
<body>
    @php
        $companySetting = Auth::user()->company->setting ?? null;
        $company = Auth::user()->company ?? null;
        $customer = $invoice->file->customer ?? null;
    @endphp

    <div class="header">
        <div>
            @if($companySetting && $companySetting->logo_path && file_exists(storage_path('app/public/'.$companySetting->logo_path)))
                <img src="{{ storage_path('app/public/'.$companySetting->logo_path) }}" class="logo" alt="Company Logo">
            @endif
            <div class="company-name">{{ $company->name ?? 'Company Name' }}</div>
            <div>{{ $company->type ?? '' }}</div>
        </div>
        <div class="company-info">
            <div style="margin-bottom: 15px;">
                <span class="badge">INVOICE</span>
            </div>
            <div>{{ $company->address ?? '-' }}</div>
            <div>{{ $company->city ?? '-' }}, {{ $company->post_code ?? '-' }}</div>
            <div>{{ $company->country ?? '-' }}</div>
            <div style="margin-top: 10px;">
                <div>VAT: {{ $companySetting->vat_number ?? '-' }}</div>
                <div>Email: {{ $company->email ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="invoice-title">INVOICE #{{ $invoice->invoice_number }}</div>

    <table class="invoice-info">
        <tr>
            <td class="label">Issued Date</td>
            <td>{{ \Carbon\Carbon::parse($invoice->issue_date)->format('d/m/Y') }}</td>
            <td class="label">Due Date</td>
            <td>{{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') : 'Upon receipt' }}</td>
        </tr>
        <tr>
            <td class="label">File Reference</td>
            <td>{{ $invoice->file->reference ?? '-' }}</td>
            <td class="label">Currency</td>
            <td>{{ $invoice->currency->code ?? $companySetting->invoice_currency ?? 'EUR' }}</td>
        </tr>
    </table>

    <div style="margin-bottom: 15px;">
        <div style="font-weight: 600; margin-bottom: 5px; color: #4b5563;">BILL TO:</div>
        <div style="font-weight: bold; margin-bottom: 3px;">{{ $customer->name ?? 'N/A' }}</div>
        <div>{{ $customer->address ?? '-' }}</div>
        <div>{{ $customer->city ?? '-' }}, {{ $customer->post_code ?? '-' }}</div>
        <div>{{ $customer->country ?? '-' }}</div>
        <div style="margin-top: 5px;">
            <div>Email: {{ $customer->email ?? '-' }}</div>
            <div>Phone: {{ $customer->phone_1 ?? '-' }}</div>
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th width="20%">Service</th>
                <th width="40%">Description</th>
                <th width="10%">Qty</th>
                <th width="15%">Unit Price</th>
                <th width="15%">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->service_name }}</td>
                <td>{{ is_array($item->description) ? json_encode($item->description) : ($item->description ?? '-') }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price, 2) }} {{ $item->currency->code ?? ($companySetting->invoice_currency ?? 'EUR') }}</td>
                <td>{{ number_format($item->total_price, 2) }} {{ $item->currency->code ?? ($companySetting->invoice_currency ?? 'EUR') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

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

    <div class="clear"></div>

    <div class="payment-details">
        <h3>PAYMENT INFORMATION</h3>
        <div style="display: flex; justify-content: space-between;">
            <div style="width: 48%;">
                <div style="margin-bottom: 5px;"><strong>Bank Transfer:</strong></div>
                <div>Bank: {{ $companySetting->bank_name ?? 'N/A' }}</div>
                <div>Account Name: {{ $companySetting->bank_account_name ?? 'N/A' }}</div>
                <div>IBAN: {{ $companySetting->iban ?? 'N/A' }}</div>
                <div>SWIFT/BIC: {{ $companySetting->swift_code ?? 'N/A' }}</div>
            </div>
            <div style="width: 48%;">
                <div style="margin-bottom: 5px;"><strong>Payment Terms:</strong></div>
                <div>Due Date: {{ $invoice->due_date ? \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') : 'Upon receipt' }}</div>
                <div>Payment Method: Bank Transfer</div>
                <div>Currency: {{ $invoice->currency->code ?? ($companySetting->invoice_currency ?? 'EUR') }}</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div>{{ $company->name ?? 'Company Name' }}</div>
        <div>{{ $company->address ?? '-' }}, {{ $company->city ?? '-' }} {{ $company->post_code ?? '-' }}, {{ $company->country ?? '-' }}</div>
        <div>VAT: {{ $companySetting->vat_number ?? '-' }} | Email: {{ $company->email ?? '-' }}</div>
        <div style="margin-top: 10px;">{{ $companySetting->notes ?? 'Thank you for your business!' }}</div>
    </div>
</body>
</html>