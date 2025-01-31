<?php

return [
    // SSO API Endpoint
    'sso_url' => env('SSO_URL', 'https://sso.jrwebdesigns.co.za/api'),

    'sso_application_token' => env('SSO_APPLICATION_TOKEN', 'YOUR_APPLICATION'),

    // Enable API Mode
    'api_enabled' => false,

    // Custom afterLogin callback (e.g., "[\App\Http\CustomAuthController::class, 'afterLogin']")
    'after_login_callback' => null,

    // Custom logout callback (e.g., "[\App\Http\CustomAuthController::class, 'logout']")
    'logout_callback' => null,

    // Database connection to use for SSO user storage
    'database_connection' => env('SSO_DATABASE_CONNECTION', null),
];