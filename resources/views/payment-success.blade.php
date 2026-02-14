@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
<section style="padding: 100px 0; text-align: center;">
    <div class="container" style="max-width: 600px;">
        <div style="width: 100px; height: 100px; background: #000000; border-radius: 50%; margin: 0 auto 30px; display: flex; align-items: center; justify-content: center;">
            <span style="color: #ffffff; font-size: 48px;">✓</span>
        </div>
        
        <h1 style="font-size: 40px; margin-bottom: 20px;">Payment Successful!</h1>
        <p style="font-size: 18px; opacity: 0.7; margin-bottom: 30px; line-height: 1.6;">
            Thank you for your purchase. Your order has been confirmed and you will receive a confirmation email shortly.
        </p>

        <div style="background: #f5f5f5; padding: 30px; margin-bottom: 40px; text-align: left;">
            <h3 style="margin-bottom: 20px;">Order Details</h3>
            <div style="margin-bottom: 10px;">
                <strong>Order ID:</strong> #{{ $order->id }}
            </div>
            <div style="margin-bottom: 10px;">
                <strong>Service:</strong> {{ $order->service->title }}
            </div>
            <div style="margin-bottom: 10px;">
                <strong>Amount:</strong> ₹{{ number_format($order->amount, 2) }}
            </div>
            <div style="margin-bottom: 10px;">
                <strong>Transaction ID:</strong> {{ $order->transaction_id }}
            </div>
            <div>
                <strong>Status:</strong> <span style="color: green;">PAID</span>
            </div>
        </div>

        <a href="{{ route('home') }}" class="btn-primary" style="text-decoration: none; display: inline-block;">Back to Home</a>
    </div>
</section>
@endsection
