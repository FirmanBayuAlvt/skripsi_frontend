<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */

    // Backend API Configuration
    'backend' => [
        'base_url' => env('BACKEND_API_URL', 'http://localhost:8000/api'),
    ],

    // ML Service Configuration
    'ml_service' => [
        'url' => env('ML_SERVICE_URL', 'http://localhost:8002'),
    ],

    // REST API (untuk login, gunakan backend)
    'rest' => [
        'endpoint' => env('BACKEND_API_URL', 'http://localhost:8000/api'),
    ],

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
