<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        // Local development
        'http://localhost:3000',
        'http://127.0.0.1:3000',
        'http://localhost:5173',
        'http://127.0.0.1:5173',

        // Public website
        'https://www.luxurygardenpalace.com',
        'https://luxurygardenpalace.com',

        // Dashboard
        'https://www.dashboard.luxurygardenpalace.com',
        'https://dashboard.luxurygardenpalace.com',

        // API domain, useful for direct browser/API tools
        'https://www.api.luxurygardenpalace.com',
        'https://api.luxurygardenpalace.com',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,
];