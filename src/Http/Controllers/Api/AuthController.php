<?php

namespace LaravelLogin\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use LaravelLogin\Http\Controllers\AuthController as BaseAuthController;
use GuzzleHttp\Exception\RequestException;

class AuthController extends BaseAuthController
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // Call SSO API
            $client = Http::withToken(config('laravel-login.sso_application_token'));
            $response = $client->post(config('laravel-sso-login.sso_url') . "/sign-in", [
                'body' => json_encode($credentials),
            ]);


            if($response->getStatusCode() !== 200) {
                return back()->withErrors([
                    'email' => 'Invalid credentials.',
                ]);
            }

            $userData = json_decode($response->getBody(), true);

            // Trigger afterLogin logic
            return $this->afterLogin($userData);

        } catch (RequestException $e) {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ]);
        }
    }

    protected function afterLogin($userData)
    {
        // Use custom callback if defined
        $callback = config('laravel-sso-login.after_login_callback');
        if ($callback && is_callable($callback)) {
            return call_user_func($callback, $userData);
        }

        // Default behavior: Store user in session
        session(['user' => $userData]);
        return $userData;
    }
}