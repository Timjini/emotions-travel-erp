@php
$addressParts = array_filter([
    $invoice->company->address,
    $invoice->company->post_code,
    $invoice->company->city,
    $invoice->company->district,
    $invoice->company->country
]);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Invoice from {{ config('app.name') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #2D3748;
            margin: 0;
            padding: 0;
            background-color: #F7FAFC;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #FFFFFF;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
            text-align: center;
            color: white;
        }
        .logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            letter-spacing: -0.5px;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 500;
            color: #2D3748;
            margin-bottom: 24px;
        }
        .message {
            background: #F8FAFC;
            padding: 24px;
            border-radius: 12px;
            border-left: 4px solid #667eea;
            margin: 32px 0;
        }
        .invoice-info {
            background: #F7FAFC;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin: 32px 0;
            border: 1px solid #E2E8F0;
        }
        .invoice-number {
            font-size: 20px;
            font-weight: 600;
            color: #4A5568;
            margin-bottom: 8px;
        }
        .attachment-note {
            font-size: 16px;
            color: #4A5568;
            margin-bottom: 16px;
        }
        .support {
            background: #EBF5FF;
            padding: 20px;
            border-radius: 12px;
            margin: 32px 0;
            text-align: center;
        }
        .support-title {
            font-weight: 600;
            color: #2C5282;
            margin-bottom: 8px;
        }
        .support-email {
            color: #3182CE;
            text-decoration: none;
            font-weight: 500;
        }
        .footer {
            background: #F7FAFC;
            padding: 32px 40px;
            text-align: center;
            border-top: 1px solid #E2E8F0;
        }
        .thank-you {
            font-size: 16px;
            font-weight: 500;
            color: #4A5568;
            margin-bottom: 16px;
        }
        .company-info {
            font-size: 14px;
            color: #718096;
            line-height: 1.5;
        }
        .signature {
            margin-top: 24px;
            color: #667eea;
            font-weight: 500;
        }
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #E2E8F0, transparent);
            margin: 32px 0;
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="content">
            <div class="greeting">
                Dear {{$invoice->file->customer->name  ?? 'Sir/Madam'}},
            </div>

            <p>We hope this message finds you well. Your invoice has been prepared and is ready for your review.</p>

            <div class="invoice-info">
                <div class="invoice-number">Invoice #{{ $invoice->invoice_number }}</div>
                <div class="attachment-note">Please find your detailed invoice attached as a PDF document.</div>
            </div>

            <div class="support">
                <div class="support-title">Need assistance?</div>
                <p>Our billing team is here to help with any questions you may have regarding your invoice.</p>
                <p>Email us at: <a href="mailto:{{$invoice->company->email ?? ''}}" class="support-email">{{$invoice->company->email ?? ''}}</a></p>
            </div>

            <div class="divider"></div>


            <p><strong>Booking Dates:</strong><br>
                {{ $invoice->file->start_date->format('M d, Y') }} - {{ $invoice->file->end_date->format('M d, Y') }}
            </p>
        </div>

        <div class="footer">
            <div class="thank-you">
                Thank you for choosing {{ $invoice->company->name ?? 'Us' }}.
            </div>
            
            <div class="company-info">
                <strong>{{ config('app.name') }}</strong><br>
                {{ implode(', ', $addressParts) }}<br>
                {{ $invoice->company->phone ?? config('app.phone') }} | {{ $invoice->company->email ??  config('app.email') }}
            </div>

            <div class="signature">
                With gratitude,<br>
                The {{ config('app.name') }} Team
            </div>
        </div>
    </div>
</body>
</html>