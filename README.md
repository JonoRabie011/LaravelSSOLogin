# Laravel Login Package

A Laravel package for SSO login with customizable `afterLogin` behavior.

## Installation

```bash
composer require jrwebdesigns/laravel-sso-login
```

If you would like to publish override the afterLogin behavior, you can add a laravel-sso-login.php config file to your config directory:

```php

<?php

return [
    // SSO API Endpoint
    'sso_url' => env('SSO_URL', 'https://sso.jrwebdesigns.co.za/api'),

    'sso_application_token' => env('SSO_APPLICATION_TOKEN', 'YOUR_APPLICATION'),

    // Enable API Mode
    'api_enabled' => false,

    // Custom afterLogin callback (e.g., "[\App\Http\CustomAuthController::class, 'afterLogin']")
    'after_login_callback' => null,
];

```


### 200 Success


## After login Response Data will be in the following format:

### 200 OK
```json

{
  "guuid": "********-****-****-****-************",
  "firstName": "John",
  "lastName": "Doe",
  "email": "example@example.com",
  "dateModified": "26-12-2024 10:12:20",
  "dateCreated": "26-12-2024 10:12:20",
  "token": "eyJhbGciOi...truncated...Bp5ddhQ",
  "refreshToken": "**************",
  "subscription": {
    "applicationId": "1",
    "lastRenewalDate": "26-12-2024 00:00:00",
    "nextBillingInvoiceId": "-1",
    "nextBillingDate": "25-01-2025 00:00:00",
    "status": "Active",
    "subscriptionPackage": {
      "title": "Free",
      "description": "Free subscription package",
      "newPriceEffectiveDate": null,
      "durationDays": null,
      "trailLength": "0",
      "priceHistory": null,
      "currentPricing": {
        "price": "0.00",
        "currency": "ZAR"
      },
      "associatedRole": {
        "name": "Admin",
        "permissions": "tdQ3wWyJjYW4gdmlldyBhbGwiXQ=="
      }
    }
  }
}
```

### 400 Bad Request
```json
"Invalid email or password"
```

### 401 Unauthorized
```json
 "Unauthorized"
```