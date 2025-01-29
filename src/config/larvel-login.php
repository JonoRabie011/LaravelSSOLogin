<?php

return [
    // SSO API Endpoint
    'sso_login_url' => env('SSO_LOGIN_URL', 'https://sso.jrwebdesigns.co.za/login'),

    // Enable API Mode
    'api_enabled' => false,

    // Custom afterLogin callback (e.g., "App\Http\Controllers\CustomAuthController@afterLogin")
    'after_login_callback' => null,
];