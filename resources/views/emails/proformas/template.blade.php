<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Proforma Invoice #{{ $proforma->proforma_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
            color: #111827;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
        }
        .section {
            padding: 20px;
        }
        .section p {
            margin: 6px 0;
            font-size: 14px;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 12px;
            border-radius: 6px;
        }
        .badge.draft { background: #f3f4f6; color: #374151; }
        .badge.sent { background: #dbeafe; color: #1e40af; }
        .badge.paid { background: #dcfce7; color: #166534; }
        .badge.overdue { background: #fee2e2; color: #991b1b; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        table th, table td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
            font-size: 13px;
        }
        .footer {
            padding: 16px 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
        }
        .btn:hover {
            background: #1e40af;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <h2>Proforma #{{ $proforma->proforma_number }}</h2>
        <span class="badge {{ $proforma->status }}">
            {{ ucfirst($proforma->status) }}
        </span>
    </div>

    <!-- Customer Info -->
    <div class="section">
        <p><strong>Customer:</strong> {{ $proforma->file->customer->name }}</p>
        <p><strong>Email:</strong> {{ $proforma->file->customer->email }}</p>
        <p><strong>Issue Date:</strong> {{ $proforma->issue_date->format('M d, Y') }}</p>
        <p><strong>Due Date:</strong> {{ $proforma->due_date?->format('M d, Y') ?? 'N/A' }}</p>
    </div>

    <!-- Items Table -->
    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach($proforma->file->items as $item)
                <tr>
                    <td>{{ $item->service_name }}</td>
                    <td>{{ $item->description ?? '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }} {{ $proforma->currency->code }}</td>
                    <td>{{ number_format($item->total_price, 2) }} {{ $proforma->currency->code }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <p style="margin-top: 16px; font-size: 16px;">
            <strong>Total Amount: {{ number_format($proforma->total_amount, 2) }} {{ $proforma->currency->code }}</strong>
        </p>
    </div>

    <!-- Notes -->
    @if($proforma->notes)
        <div class="section">
            <p><strong>Notes:</strong></p>
            <p>{{ $proforma->notes }}</p>
        </div>
    @endif

    <!-- Call to Action -->
    <div class="section" style="text-align: center;">
        <a href="{{ route('proformas.show', $proforma) }}" class="btn">
            View Proforma Online
        </a>
    </div>

    <!-- Footer -->
    <div class="footer">
        Created {{ $proforma->created_at->format('M d, Y H:i') }}  
        | Last updated {{ $proforma->updated_at->format('M d, Y H:i') }}  
        <br><br>
        {{ config('app.name') }}
    </div>
</div>
</body>
</html>
