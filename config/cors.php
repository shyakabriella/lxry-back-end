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
        /*
        |--------------------------------------------------------------------------
        | Local development - React / Vite / Next
        |--------------------------------------------------------------------------
        */
        'http://localhost:3000',
        'http://127.0.0.1:3000',

        'http://localhost:5173',
        'http://localhost:5174',
        'http://localhost:5175',
        'http://localhost:5176',

        'http://127.0.0.1:5173',
        'http://127.0.0.1:5174',
        'http://127.0.0.1:5175',
        'http://127.0.0.1:5176',

        /*
        |--------------------------------------------------------------------------
        | Main public website
        |--------------------------------------------------------------------------
        */
        'https://luxurygardenpalace.com',
        'https://www.luxurygardenpalace.com',

        /*
        |--------------------------------------------------------------------------
        | Dashboard website
        |--------------------------------------------------------------------------
        */
        'https://dashboard.luxurygardenpalace.com',
        'https://www.dashboard.luxurygardenpalace.com',

        /*
        |--------------------------------------------------------------------------
        | Wedding website
        |--------------------------------------------------------------------------
        */
        'https://wedding.luxurygardenpalace.com',
        'https://www.wedding.luxurygardenpalace.com',

        /*
        |--------------------------------------------------------------------------
        | Restaurant website
        |--------------------------------------------------------------------------
        */
        'https://resto.luxurygardenpalace.com',
        'https://www.resto.luxurygardenpalace.com',

        /*
        |--------------------------------------------------------------------------
        | API domain
        |--------------------------------------------------------------------------
        */
        'https://api.luxurygardenpalace.com',
        'https://www.api.luxurygardenpalace.com',
    ],

    /*
    |--------------------------------------------------------------------------
    | Allowed Origin Patterns
    |--------------------------------------------------------------------------
    | This allows any subdomain like:
    | https://wedding.luxurygardenpalace.com
    | https://www.wedding.luxurygardenpalace.com
    | https://api.luxurygardenpalace.com
    | https://www.api.luxurygardenpalace.com
    |--------------------------------------------------------------------------
    */
    'allowed_origins_patterns' => [
        '/^http:\/\/localhost:\d+$/',
        '/^http:\/\/127\.0\.0\.1:\d+$/',
        '/^https:\/\/([a-z0-9-]+\.)*luxurygardenpalace\.com$/',
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
    | false = good for normal Bearer token API authentication.
    | true = only if you use Sanctum cookie/session authentication.
    |--------------------------------------------------------------------------
    */
    'supports_credentials' => false,

];