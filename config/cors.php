<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'login',
        'logout',
        'register',
    ],

    'allowed_methods' => ['*'],
    'allowed_origins' => [
        // Local development - React / Vite / Next
        'http://localhost:3000',
        'http://127.0.0.1:3000',
        'http://localhost:5173',
        'http://localhost:5174',
        'http://localhost:5175',
        'http://localhost:5176',
        'http://127.0.0.1:5173',

        // Public website
        'https://luxurygardenpalace.com',
        'https://www.luxurygardenpalace.com',

        // Dashboard
        'https://dashboard.luxurygardenpalace.com',
        'https://www.dashboard.luxurygardenpalace.com',

        // API domain
        'https://api.luxurygardenpalace.com',
        'https://www.api.luxurygardenpalace.com',
    ],

    'allowed_origins_patterns' => [
        '/^http:\/\/localhost:\d+$/',
        '/^http:\/\/127\.0\.0\.1:\d+$/',
        '/^https:\/\/([a-z0-9-]+\.)?luxurygardenpalace\.com$/',
    ],

    'allowed_headers' => [
        '*',
    ],

    'exposed_headers' => [],

    'max_age' => 86400,

    /*
    |--------------------------------------------------------------------------
    | Supports Credentials
    |--------------------------------------------------------------------------
    | If you use Laravel Sanctum cookie authentication, set this to true.
    | If you use normal API token/Bearer token login, false is okay.
    */
    'supports_credentials' => false,

];