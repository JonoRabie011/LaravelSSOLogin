<?php

namespace LaravelLogin\Http\Controllers\Api;

use Illuminate\Http\Request;
use LaravelLogin\Http\Controllers\AuthController as BaseAuthController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AuthController extends BaseAuthController
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            $client = new Client();
            $response = $client->post(config('laravel-login.sso_login_url') . "/sign-in", [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('laravel-login.sso_application_token'),
                ],
                'body' => $credentials,
            ]);

            $userData = json_decode($response->getBody(), true);

            // Return JSON response for API
            return response()->json([
                'success' => true,
                'user' => $userData,
            ]);

        } catch (RequestException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.',
            ], 401);
        }
    }
}