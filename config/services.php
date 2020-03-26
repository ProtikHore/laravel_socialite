<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => '110946608964-hpm0tj3049ojnkfu4elsh3c12p3hbin3.apps.googleusercontent.com',
        'client_secret' => 'GFgWmKeUJ6fJpAU2M5SM2hbd',
        'redirect' => 'http://localhost:8000/login/google/callback',
    ],

    'facebook' => [
        'client_id' => '151067352847119',
        'client_secret' => 'a595e90fd572f343559732c6fe0a2672',
        'redirect' => 'http://localhost:8000/login/facebook/callback',
    ],
];
