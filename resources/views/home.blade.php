@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section style="padding: 100px 0; text-align: center; background: linear-gradient(180deg, #f5f5f5 0%, #ffffff 100%);">
    <div class="container">
        <h1 style="font-size: 56px; margin-bottom: 20px;">Professional Software Solutions</h1>
        <p style="font-size: 20px; opacity: 0.7; max-width: 600px; margin: 0 auto 40px;">
            Transform your business with cutting-edge technology and expert software development services.
        </p>
        <div>
            <a href="{{ route('services') }}" class="btn-primary" style="text-decoration: none; display: inline-block; margin-right: 15px;">View Services</a>
            <a href="{{ route('contact') }}" class="btn-secondary" style="text-decoration: none; display: inline-block;">Get in Touch</a>
        </div>
    </div>
</section>

<!-- Featured Services -->
<section style="padding: 80px 0;">
    <div class="container">
        <h2 style="font-size: 40px; text-align: center; margin-bottom: 60px;">Our Services</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px;">
            @foreach($services as $service)
            <div style="border: 1px solid #e5e5e5; padding: 40px; transition: all 0.3s; cursor: pointer;" 
                 onmouseover="this.style.boxShadow='0 10px 40px rgba(0,0,0,0.1)'" 
                 onmouseout="this.style.boxShadow='none'">
                <h3 style="font-size: 24px; margin-bottom: 15px;">{{ $service->title }}</h3>
                <p style="opacity: 0.7; margin-bottom: 20px; line-height: 1.6;">{{ Str::limit($service->description, 100) }}</p>
                <p style="font-size: 28px; font-weight: 600; margin-bottom: 20px;">₹{{ number_format($service->price, 2) }}</p>
                <a href="{{ route('checkout', $service) }}" class="btn-primary" style="text-decoration: none; display: inline-block; width: 100%; text-align: center;">Purchase</a>
            </div>
            @endforeach
        </div>
        
        <div style="text-align: center; margin-top: 60px;">
            <a href="{{ route('services') }}" class="btn-secondary" style="text-decoration: none; display: inline-block;">View All Services</a>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section style="padding: 80px 0; background: #f5f5f5;">
    <div class="container">
        <h2 style="font-size: 40px; text-align: center; margin-bottom: 60px;">Why Choose TechAk?</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px;">
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: #000000; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 32px; font-weight: 700;">01</div>
                <h3 style="margin-bottom: 15px;">Expert Team</h3>
                <p style="opacity: 0.7; line-height: 1.6;">Experienced developers with proven track records</p>
            </div>
            
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: #000000; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 32px; font-weight: 700;">02</div>
                <h3 style="margin-bottom: 15px;">Quality Delivery</h3>
                <p style="opacity: 0.7; line-height: 1.6;">On-time delivery with exceptional quality standards</p>
            </div>
            
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: #000000; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 32px; font-weight: 700;">03</div>
                <h3 style="margin-bottom: 15px;">24/7 Support</h3>
                <p style="opacity: 0.7; line-height: 1.6;">Round-the-clock support for all your needs</p>
            </div>
            
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; background: #000000; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 32px; font-weight: 700;">04</div>
                <h3 style="margin-bottom: 15px;">Secure Payment</h3>
                <p style="opacity: 0.7; line-height: 1.6;">Safe and secure payment via PhonePe integration</p>
            </div>
        </div>
    </div>
</section>
@endsection
