<?php

return [
    // SSO API Endpoint
    'sso_url' => env('SSO_URL', 'https://sso.jrwebdesigns.co.za/api'),

    'sso_application_token' => env('SSO_APPLICATION_TOKEN', 'YOUR_APPLICATION'),

    // Enable API Mode
    'api_enabled' => false,

    // Custom afterLogin callback (e.g., "App\Http\Controllers\CustomAuthController@afterLogin")
    'after_login_callback' => null,
];