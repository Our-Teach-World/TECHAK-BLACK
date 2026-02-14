@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<section style="padding: 80px 0;">
    <div class="container" style="max-width: 800px;">
        <h1 style="font-size: 40px; margin-bottom: 40px; text-align: center;">Checkout</h1>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
            <!-- Order Summary -->
            <div style="border: 1px solid #e5e5e5; padding: 30px;">
                <h2 style="font-size: 24px; margin-bottom: 20px;">Order Summary</h2>
                <h3 style="margin-bottom: 15px;">{{ $service->title }}</h3>
                <p style="opacity: 0.7; margin-bottom: 20px; line-height: 1.6;">{{ $service->description }}</p>
                <div style="border-top: 1px solid #e5e5e5; padding-top: 20px; margin-top: 20px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span>Subtotal</span>
                        <span>₹{{ number_format($service->price, 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 20px; font-weight: 600; margin-top: 15px; padding-top: 15px; border-top: 1px solid #e5e5e5;">
                        <span>Total</span>
                        <span>₹{{ number_format($service->price, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div>
                <form action="{{ route('checkout.process', $service) }}" method="POST">
                    @csrf
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Full Name *</label>
                        <input type="text" name="name" required 
                               value="{{ old('name', auth()->user()->name ?? '') }}"
                               style="width: 100%; padding: 12px; border: 1px solid #e5e5e5; font-size: 16px;">
                        @error('name')
                            <span style="color: #ff0000; font-size: 14px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Email *</label>
                        <input type="email" name="email" required 
                               value="{{ old('email', auth()->user()->email ?? '') }}"
                               style="width: 100%; padding: 12px; border: 1px solid #e5e5e5; font-size: 16px;">
                        @error('email')
                            <span style="color: #ff0000; font-size: 14px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Phone Number *</label>
                        <input type="tel" name="phone" required 
                               value="{{ old('phone') }}"
                               placeholder="+91 1234567890"
                               style="width: 100%; padding: 12px; border: 1px solid #e5e5e5; font-size: 16px;">
                        @error('phone')
                            <span style="color: #ff0000; font-size: 14px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%; text-align: center; font-size: 16px;">
                        Proceed to Payment
                    </button>

                    <p style="text-align: center; margin-top: 20px; font-size: 14px; opacity: 0.6;">
                        Secured by PhonePe Payment Gateway
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
