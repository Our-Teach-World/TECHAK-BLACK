<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #000000; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #000000; color: #ffffff; padding: 20px; }
        .content { padding: 30px; background: #f5f5f5; }
        .button { background: #000000; color: #ffffff; padding: 12px 30px; text-decoration: none; display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Order Received</h1>
        </div>
        
        <div class="content">
            <p>A new order has been placed on TechAk.</p>
            
            <h3>Order Details:</h3>
            <p>
                <strong>Order ID:</strong> #{{ $order->id }}<br>
                <strong>Service:</strong> {{ $order->service->title }}<br>
                <strong>Amount:</strong> ₹{{ number_format($order->amount, 2) }}<br>
                <strong>Transaction ID:</strong> {{ $order->transaction_id }}<br>
                <strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}
            </p>
            
            <h3>Customer Details:</h3>
            <p>
                <strong>Name:</strong> {{ $order->name }}<br>
                <strong>Email:</strong> {{ $order->email }}<br>
                <strong>Phone:</strong> {{ $order->phone }}
            </p>
            
            <p>Please process this order and contact the customer.</p>
        </div>
    </div>
</body>
</html>
