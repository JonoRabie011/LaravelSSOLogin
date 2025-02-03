# Laravel Login Package

A Laravel package for SSO login with customizable `afterLogin` behavior.

## Installation

```bash
composer require jrwebdesigns/laravel-sso-login
```

If you would like to override the afterLogin behavior, you can add a laravel-sso-login.php config file to your config directory:

```php
<?php

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


# Models

The package comes with a User model that you can use to store the SSO user data. You can extend this model to add any additional fields you may need.

```php

namespace App\Models;

use LaravelLogin\Models\SSOUser;

class CustomUser extends SSOUser
{
    protected $table = 'users'; // Use existing users table

    // Add custom behavior if needed
}

```

Once you have created your custom user model, you can update the `config/laravel-sso-login.php` file to use your custom user model:

```php
// config/laravel-sso-login.php
return [
    'user_model' => \App\Models\CustomUser::class,
];
```
