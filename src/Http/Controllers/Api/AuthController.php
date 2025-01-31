<?php

namespace LaravelLogin\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use LaravelLogin\Models\RolePermission;
use LaravelLogin\Models\SSOUser;
use LaravelLogin\Services\PermissionService;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('laravel-sso-login::login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            $response = Http::withToken(config('laravel-sso-login.sso_application_token'))
                ->post(config('laravel-sso-login.sso_url') . "/sign-in", $credentials);


            if($response->getStatusCode() !== 200) {
                return [
                    'status' => 'error',
                    'message' => $response->body(),
                    'email' => 'Invalid credentials.',
                ];
            }

            $userData = json_decode($response->getBody(), true);

            if(empty($userData)) {
                return [
                    'status' => 'error',
                    'email' => 'You do not have permission to access this application.',
                ];
            }


            // Trigger afterLogin logic
            return $this->afterLogin($userData);

        } catch (RequestException $e) {
            return [
                'status' => 'error',
                'email' => 'Invalid credentials.',
            ];
        }
    }

    protected function afterLogin($userData)
    {

//        $user = SSOUser::updateOrCreate(
//            ['email' => $userData['email']],
//            [
//                'firstName' => $userData['firstName'],
//                'lastName' => $userData['lastName'],
//                'guuid' => $userData['guuid'],
//                'token' => $userData['token'],
//                'refreshToken' => $userData['refreshToken'],
//                'externalId' => $userData['externalId'],
//            ]
//        );
//
//        $user->markEmailAsVerified();
//
//        Auth()->login($user);

        // Use custom callback if defined
        $callback = config('laravel-sso-login.after_login_callback');
        if ($callback && is_callable($callback)) {
            return call_user_func($callback, $userData);
        }

        // Default behavior: Store user in session and redirect
        session(['user' => $userData]);

        return [
            'user' => $userData
        ];
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