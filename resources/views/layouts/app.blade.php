<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TechAk') }} - @yield('title', 'Professional Software Solutions')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: #000000;
        }

        /* Black & White Minimal Design */
        .btn-primary {
            background: #000000;
            color: #ffffff;
            padding: 12px 32px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #333333;
        }

        .btn-secondary {
            background: #ffffff;
            color: #000000;
            padding: 12px 32px;
            border: 2px solid #000000;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .btn-secondary:hover {
            background: #000000;
            color: #ffffff;
        }

        nav {
            background: #ffffff;
            border-bottom: 1px solid #e5e5e5;
            padding: 20px 0;
        }

        nav a {
            color: #000000;
            text-decoration: none;
            margin: 0 20px;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        nav a:hover {
            opacity: 0.7;
        }

        footer {
            background: #000000;
            color: #ffffff;
            padding: 40px 0;
            margin-top: 80px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        h1, h2, h3 {
            font-weight: 600;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('home') }}" style="font-size: 24px; font-weight: 700; margin: 0;">TechAk</a>
            
            <div>
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('services') }}">Services</a>
                <a href="{{ route('contact') }}">Contact</a>
                
                @auth
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div style="background: #000000; color: #ffffff; padding: 15px; text-align: center;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #ff0000; color: #ffffff; padding: 15px; text-align: center;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px;">
                <div>
                    <h3 style="margin-bottom: 20px;">TechAk</h3>
                    <p style="opacity: 0.8;">Professional software solutions for your business needs.</p>
                </div>
                
                <div>
                    <h4 style="margin-bottom: 20px;">Quick Links</h4>
                    <a href="{{ route('services') }}" style="display: block; color: #ffffff; text-decoration: none; margin-bottom: 10px; opacity: 0.8;">Services</a>
                    <a href="{{ route('about') }}" style="display: block; color: #ffffff; text-decoration: none; margin-bottom: 10px; opacity: 0.8;">About Us</a>
                    <a href="{{ route('contact') }}" style="display: block; color: #ffffff; text-decoration: none; opacity: 0.8;">Contact</a>
                </div>
                
                <div>
                    <h4 style="margin-bottom: 20px;">Contact Info</h4>
                    <p style="opacity: 0.8; margin-bottom: 10px;">Email: info@techak.com</p>
                    <p style="opacity: 0.8;">Phone: +91 1234567890</p>
                </div>
            </div>
            
            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #333333; text-align: center; opacity: 0.6;">
                &copy; {{ date('Y') }} TechAk. All rights reserved.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
