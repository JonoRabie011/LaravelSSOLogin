<?php

namespace LaravelLogin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('laravel-login::login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // Call SSO API
            $client = new Client();
            $response = $client->post(config('laravel-login.sso_login_url'), [
                'json' => $credentials,
            ]);

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
        $callback = config('laravel-login.after_login_callback');
        if ($callback && is_callable($callback)) {
            return call_user_func($callback, $userData);
        }

        // Default behavior: Store user in session and redirect
        session(['user' => $userData]);
        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect('/login');
    }
}