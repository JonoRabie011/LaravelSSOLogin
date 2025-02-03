<?php

namespace LaravelLogin\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use LaravelLogin\Models\SSOUser;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('laravel-sso-login::login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['device_ip'] = $request->ip();
        $credentials['keep_logged_in'] = true;

        try {
            $response = Http::withToken(config('laravel-sso-login.sso_application_token'))
                ->post(config('laravel-sso-login.sso_url') . "/sign-in", $credentials);


            if($response->getStatusCode() !== 200) {
                return back()->withErrors([
                    'message' => 'Invalid credentials.',
                ]);
            }

            $userData = json_decode($response->getBody(), true);

            if(empty($userData)) {
                return back()->withErrors([
                    'message' => 'You do not have permission to access this application.',
                ]);
            }


            // Trigger afterLogin logic
            return $this->afterLogin($userData);

        } catch (RequestException $e) {
            return back()->withErrors([
                'message' => 'Invalid credentials.',
            ]);
        }
    }

    protected function afterLogin($userData)
    {

        $user = SSOUser::updateOrCreate(
            ['email' => $userData['email']],
            [
                'firstName' => $userData['firstName'],
                'lastName' => $userData['lastName'],
                'guuid' => $userData['guuid'],
                'token' => $userData['token'],
                'refreshToken' => $userData['refreshToken'],
            ]
        );


        $role = $userData['subscription']["subscriptionPackage"]["associatedRole"];

        $permissions = (array) base64_decode(substr($role['permission'], 5));

        foreach ($permissions as $permission) {
            $user->role()->updateOrCreate([
                'name' => $role['name'],
                'permission' => $permission,
            ]);
        }

        $user->markEmailAsVerified();

        // Use custom callback if defined
        $callback = config('laravel-sso-login.after_login_callback');
        if ($callback && is_callable($callback)) {
            return call_user_func($callback, $userData);
        }

        // Default behavior: Store user in session and redirect
        session(['user' => $userData]);
        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {

        // Use custom callback if defined
        $callback = config('laravel-sso-login.logout_callback');
        if ($callback && is_callable($callback)) {
            return call_user_func($callback, $request);
        }

        $request->session()->forget('user');
        return redirect('/login');
    }
}