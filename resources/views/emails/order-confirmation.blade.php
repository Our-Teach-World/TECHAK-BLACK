<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #000000; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #000000; color: #ffffff; padding: 20px; text-align: center; }
        .content { padding: 30px; background: #f5f5f5; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666666; }
        .button { background: #000000; color: #ffffff; padding: 12px 30px; text-decoration: none; display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Confirmation</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $order->name }},</p>
            
            <p>Thank you for your purchase! Your order has been confirmed and payment received successfully.</p>
            
            <h3>Order Details:</h3>
            <p>
                <strong>Order ID:</strong> #{{ $order->id }}<br>
                <strong>Service:</strong> {{ $order->service->title }}<br>
                <strong>Amount:</strong> ₹{{ number_format($order->amount, 2) }}<br>
                <strong>Transaction ID:</strong> {{ $order->transaction_id }}<br>
                <strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}
            </p>
            
            <p>We will get in touch with you shortly to discuss the next steps.</p>
            
            <p>If you have any questions, please don't hesitate to contact us.</p>
            
            <a href="{{ route('home') }}" class="button">Visit Website</a>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} TechAk. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
