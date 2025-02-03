<?php

use LaravelLogin\Models\SSOUser;

return [
    // SSO API Endpoint (provided by SSO)
    'sso_url' => env('SSO_URL', 'https://sso.jrwebdesigns.co.za/api'),

    // SSO Application token (provided by SSO)
    'sso_application_token' => env('SSO_APPLICATION_TOKEN'),

    // Enable API Mode
    'api_enabled' => false,

    // Custom afterLogin callback (e.g., "[\App\Http\CustomAuthController::class, 'afterLogin']")
    'after_login_callback' => null,

    // Custom logout callback (e.g., "[\App\Http\CustomLogoutController::class, 'logout']")
    'logout_callback' => null,

    // User model to use for SSO user storage
    'user_model' => SSOUser::class,

    // Table to use for SSO user storage (if not using the default Laravel users table)
    'user_table' => env('SSO_USER_TABLE', 'sso_users'),

    // Database connection to use for SSO user storage
    'database_connection' => env('SSO_DATABASE_CONNECTION'),
];