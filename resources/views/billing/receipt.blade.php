<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $paymentData['receipt_number'] ?? 'RCT-' . $bill->id }}</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }
        .receipt {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px dashed #333;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .receipt-header h1 {
            font-size: 24px;
            margin: 0;
            color: #1e40af;
        }
        .receipt-header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }
        .receipt-info {
            margin-bottom: 20px;
        }
        .receipt-info div {
            margin: 8px 0;
            font-size: 14px;
        }
        .receipt-info strong {
            display: inline-block;
            width: 120px;
            color: #333;
        }
        .receipt-items {
            margin: 20px 0;
        }
        .receipt-items table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .receipt-items th {
            text-align: left;
            border-bottom: 1px solid #ddd;
            padding: 8px 0;
            font-weight: bold;
        }
        .receipt-items td {
            padding: 5px 0;
            vertical-align: top;
        }
        .receipt-items .text-right {
            text-align: right;
        }
        .receipt-total {
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 20px;
        }
        .receipt-total div {
            margin: 8px 0;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
        }
        .receipt-total .grand-total {
            font-size: 16px;
            font-weight: bold;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            margin-top: 8px;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px dashed #333;
            font-size: 12px;
            color: #666;
        }
        .payment-method {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            font-size: 12px;
        }
        .print-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #1e40af;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .print-btn:hover {
            background: #1e3a8a;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .receipt {
                box-shadow: none;
                border: none;
                margin: 0;
                max-width: 100%;
            }
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="receipt-header">
            <h1>CITYCARE MEDICAL CENTRE</h1>
            <p>123 Hospital Avenue, Kampala, Uganda</p>
            <p>Tel: +256 414 123456 | Email: info@citycare.ug</p>
            <p>www.citycare.ug</p>
        </div>

        <div class="receipt-info">
            <div><strong>Receipt No:</strong> {{ $paymentData['receipt_number'] ?? 'RCT-' . $bill->id }}</div>
            <div><strong>Date:</strong> {{ now()->format('d M Y H:i') }}</div>
            <div><strong>Cashier:</strong> {{ Auth::user()->name }}</div>
            <div><strong>Patient:</strong> {{ $bill->user->name }}</div>
            <div><strong>Patient ID:</strong> {{ $bill->user->id }}</div>
            @if($bill->user->email)
            <div><strong>Email:</strong> {{ $bill->user->email }}</div>
            @endif
        </div>

        <div class="payment-method">
            <strong>Payment Method:</strong> {{ ucfirst($paymentData['payment_method'] ?? $bill->payment_method ?? 'Unknown') }}
            @if($paymentData['payment_method'] === 'mobile_money' && isset($paymentData['phone_number']))
            <br><strong>Phone:</strong> {{ $paymentData['phone_number'] }} ({{ ucfirst($paymentData['mobile_provider']) }})
            @endif
            @if($paymentData['payment_method'] === 'card' && isset($paymentData['card_last4']))
            <br><strong>Card:</strong> **** **** **** {{ $paymentData['card_last4'] }}
            @endif
        </div>

        <div class="receipt-items">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @if($bill->items && is_array($bill->items))
                        @foreach($bill->items as $item)
                            <tr>
                                <td>{{ $item['name'] ?? 'Unknown Item' }}</td>
                                <td class="text-right">{{ $item['quantity'] ?? 1 }}</td>
                                <td class="text-right">{{ number_format($item['price'] ?? 0, 0) }}</td>
                                <td class="text-right">{{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0) }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <div class="receipt-total">
            <div>
                <span>Subtotal:</span>
                <span>UGX {{ number_format($bill->total_amount, 0) }}</span>
            </div>
            <div>
                <span>VAT (18%):</span>
                <span>UGX {{ number_format($bill->total_amount * 0.18, 0) }}</span>
            </div>
            <div class="grand-total">
                <span>TOTAL PAID:</span>
                <span>UGX {{ number_format($bill->total_amount * 1.18, 0) }}</span>
            </div>
        </div>

        @if($paymentData['notes'] ?? null)
        <div style="margin: 20px 0; padding: 10px; background: #f8f9fa; border-radius: 5px; font-size: 12px;">
            <strong>Notes:</strong> {{ $paymentData['notes'] }}
        </div>
        @endif

        <div class="receipt-footer">
            <p><strong>Thank you for choosing CityCare Medical Centre!</strong></p>
            <p>This receipt is computer generated and valid without signature</p>
            <p>For inquiries, please contact our billing department</p>
            <p style="margin-top: 20px; font-size: 10px;">
                Powered by CityCare HMS v1.0 | {{ date('Y') }}
            </p>
        </div>
    </div>

    <button class="print-btn" onclick="window.print()">
        <i class="bi bi-printer"></i> Print Receipt
    </button>

    <script>
        // Auto-print when page loads (optional)
        // window.onload = function() {
        //     window.print();
        // };
    </script>
</body>
</html>
