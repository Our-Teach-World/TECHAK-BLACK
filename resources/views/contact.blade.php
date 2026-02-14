@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<section style="padding: 80px 0;">
    <div class="container" style="max-width: 800px;">
        <h1 style="font-size: 40px; margin-bottom: 20px; text-align: center;">Get in Touch</h1>
        <p style="text-align: center; font-size: 18px; opacity: 0.7; margin-bottom: 60px;">
            Have a question or want to work together? We'd love to hear from you.
        </p>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px;">
            <!-- Contact Form -->
            <div>
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Name *</label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                               style="width: 100%; padding: 12px; border: 1px solid #e5e5e5; font-size: 16px;">
                        @error('name')
                            <span style="color: #ff0000; font-size: 14px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Email *</label>
                        <input type="email" name="email" required value="{{ old('email') }}"
                               style="width: 100%; padding: 12px; border: 1px solid #e5e5e5; font-size: 16px;">
                        @error('email')
                            <span style="color: #ff0000; font-size: 14px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500;">Message *</label>
                        <textarea name="message" required rows="6"
                                  style="width: 100%; padding: 12px; border: 1px solid #e5e5e5; font-size: 16px; resize: vertical;">{{ old('message') }}</textarea>
                        @error('message')
                            <span style="color: #ff0000; font-size: 14px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%; text-align: center;">
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 style="font-size: 24px; margin-bottom: 30px;">Contact Information</h3>
                
                <div style="margin-bottom: 30px;">
                    <h4 style="margin-bottom: 10px; font-weight: 600;">Email</h4>
                    <p style="opacity: 0.7;">info@techak.com</p>
                    <p style="opacity: 0.7;">support@techak.com</p>
                </div>

                <div style="margin-bottom: 30px;">
                    <h4 style="margin-bottom: 10px; font-weight: 600;">Phone</h4>
                    <p style="opacity: 0.7;">+91 1234567890</p>
                </div>

                <div style="margin-bottom: 30px;">
                    <h4 style="margin-bottom: 10px; font-weight: 600;">Address</h4>
                    <p style="opacity: 0.7;">123 Tech Street<br>Bangalore, Karnataka 560001<br>India</p>
                </div>

                <div>
                    <h4 style="margin-bottom: 10px; font-weight: 600;">Business Hours</h4>
                    <p style="opacity: 0.7;">Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM<br>Sunday: Closed</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
