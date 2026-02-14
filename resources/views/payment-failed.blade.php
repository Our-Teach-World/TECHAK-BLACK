@extends('layouts.app')

@section('title', 'Payment Failed')

@section('content')
<section style="padding: 100px 0; text-align: center;">
    <div class="container" style="max-width: 600px;">
        <div style="width: 100px; height: 100px; background: #ff0000; border-radius: 50%; margin: 0 auto 30px; display: flex; align-items: center; justify-content: center;">
            <span style="color: #ffffff; font-size: 48px;">✕</span>
        </div>
        
        <h1 style="font-size: 40px; margin-bottom: 20px;">Payment Failed</h1>
        <p style="font-size: 18px; opacity: 0.7; margin-bottom: 40px; line-height: 1.6;">
            Unfortunately, your payment could not be processed. Please try again or contact support if the problem persists.
        </p>

        <div>
            <a href="{{ route('services') }}" class="btn-primary" style="text-decoration: none; display: inline-block; margin-right: 15px;">View Services</a>
            <a href="{{ route('contact') }}" class="btn-secondary" style="text-decoration: none; display: inline-block;">Contact Support</a>
        </div>
    </div>
</section>
@endsection
