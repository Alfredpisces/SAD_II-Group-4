<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Order #{{ $order->id }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
            }

            .no-print {
                display: none !important;
            }
        }

        body {
            font-family: 'Courier New', monospace;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .receipt {
            width: 80mm;
            background: white;
            padding: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .receipt-header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .receipt-header p {
            margin: 3px 0;
            font-size: 10px;
        }

        .receipt-body {
            margin: 10px 0;
            font-size: 11px;
        }

        .receipt-item {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            border-bottom: 1px dashed #ccc;
            padding: 5px 0;
        }

        .receipt-item-left {
            flex: 1;
        }

        .receipt-item-right {
            text-align: right;
        }

        .receipt-total {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 5px 0;
            margin: 10px 0;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
        }

        .receipt-qr {
            text-align: center;
            margin: 10px 0;
            padding: 10px 0;
            border-top: 1px dashed #ccc;
            border-bottom: 1px dashed #ccc;
        }

        .receipt-qr #qrcode {
            display: inline-block;
        }

        .receipt-footer {
            text-align: center;
            font-size: 9px;
            margin-top: 10px;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
            no-print: all;
        }

        button {
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-print {
            background: #3D2314;
            color: white;
        }

        .btn-print:hover {
            background: #2a1810;
        }

        .btn-close {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-close:hover {
            background: #d1d5db;
        }
    </style>
</head>

<body>
    <div>
        <div class="receipt">
            <div class="receipt-header">
                <h1>☕ CafeEase</h1>
                <p>Thank You for Your Order!</p>
                <p>Order ID: #{{ $order->id }}</p>
                <p>{{ now()->format('M d, Y H:i') }}</p>
            </div>

            <div class="receipt-body">
                <div class="receipt-item">
                    <div class="receipt-item-left">
                        <strong>Item</strong>
                    </div>
                    <div class="receipt-item-right">
                        <strong>Subtotal</strong>
                    </div>
                </div>

                <div class="receipt-item">
                    <div class="receipt-item-left">
                        {{ $order->item_name }}<br>
                        <span style="font-size: 9px;">₱{{ number_format($order->price, 2) }} x {{ $order->quantity }}</span>
                    </div>
                    <div class="receipt-item-right">
                        ₱{{ number_format($order->total, 2) }}
                    </div>
                </div>
            </div>

            <div class="receipt-total">
                <span>TOTAL:</span>
                <span>₱{{ number_format($order->total, 2) }}</span>
            </div>

            <div class="receipt-qr">
                <p style="margin: 5px 0; font-size: 9px;">Scan to provide feedback</p>
                <div id="qrcode"></div>
                <p style="margin: 5px 0; font-size: 8px;">Order Status: {{ ucfirst($order->status) }}</p>
            </div>

            <div class="receipt-footer">
                <p>Status: {{ ucfirst($order->status) }}</p>
                <p>Your order will be prepared shortly.</p>
                <p>Thank you! Come again!</p>
            </div>
        </div>

        <div class="button-group no-print">
            <button class="btn-print" onclick="window.print()">🖨️ Print Receipt</button>
            <button class="btn-close" onclick="window.close()">✕ Close</button>
        </div>
    </div>

    <script>
        // Generate QR code pointing to feedback page with order ID
        const feedbackUrl = "{{ url('/feedback-customer') }}?order_id={{ $order->id }}";
        new QRCode(document.getElementById("qrcode"), {
            text: feedbackUrl,
            width: 128,
            height: 128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        // Auto-print on page load
        window.addEventListener('load', function() {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>

</html>
