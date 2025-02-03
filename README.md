# Laravel Login Package

A Laravel package for SSO login with customizable `afterLogin` behavior.

## Installation

```bash
composer require jrwebdesigns/laravel-sso-login
```

If you would like to override the afterLogin behavior, you can add a laravel-sso-login.php config file to your config directory:

```php
<?php

return [
    // SSO API Endpoint
    'sso_url' => env('SSO_URL', 'https://sso.jrwebdesigns.co.za/api'),

    'sso_application_token' => env('SSO_APPLICATION_TOKEN', 'YOUR_APPLICATION'),

    // Enable API Mode
    'api_enabled' => false, // Setting this to true will enable the API mode and responses will be in JSON format

    // Custom afterLogin callback (e.g., "[\App\Http\CustomAuthController::class, 'afterLogin']")
    'after_login_callback' => null,

    // Custom logout callback (e.g., "[\App\Http\CustomLogoutController::class, 'logout']")
    'logout_callback' => null,

    // Database connection to use for SSO user storage
    'database_connection' => env('SSO_DATABASE_CONNECTION', null)
];
```

Here is an example of how to override the afterLogin behavior:

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use LaravelLogin\Services\LarvelSingleSignOn;

class CustomAuthController extends Controller
{
    public static function afterLogin($userData)
    {
        // Custom afterLogin behavior

        $permission = new LarvelSingleSignOn(
            $userData['token'],
            $userData['refreshToken']
        );

        $user = User::where('email', $userData['email'])->first();

        if(!$user) {
            $user = new User();
            $user->name = $userData['firstName'] . ' ' . $userData['lastName'];
            $user->email = $userData['email'];
            $user->password = bcrypt('password');
            $user->save();
        }


        Auth()->login($user);
        $user = Auth::guard('web')->user();


        return [
            'user' => $user,
            'token' => $user->createToken('web-token', ["*"], now()->addWeek())->plainTextToken
        ];

    }
}
```

Here is an example of how to override the logout behavior:

```php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CustomLogoutController extends Controller {
    
    public static function logout(Request $request)
    {
        // Custom logout behavior
        $request->session()->forget('user');
        return redirect('/login');
    }
}
```

# Response From SSO

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

<hr/>

# Views

You can publish the views by running the following command:

```bash
php artisan vendor:publish --tag=views
```

This will copy the packages views to the into your app in, Allowing you to customize the views to your liking:

`resources/views/vendor/laravel-sso-login`
