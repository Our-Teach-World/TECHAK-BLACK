<?php

return [
    // PhonePe v2 SDK Credentials
    'client_id' => env('PHONEPE_CLIENT_ID'),
    'client_secret' => env('PHONEPE_CLIENT_SECRET'),
    'client_version' => env('PHONEPE_CLIENT_VERSION', 2),
    'merchant_id' => env('PHONEPE_MERCHANT_ID'),
    
    // Environment: Production only
    'environment' => 'PRODUCTION',
    'env' => \PhonePe\Env::PRODUCTION,
    
    // Redirect Configuration
    'redirect_url' => env('PHONEPE_REDIRECT_URL'),
    
    // Event publishing (optional)
    'publish_events' => env('PHONEPE_PUBLISH_EVENTS', false),
];
