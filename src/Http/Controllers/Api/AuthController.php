<?php

namespace LaravelLogin\Http\Controllers;

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
                    'email' => 'Invalid credentials.',
                ];
            }

            $userData = json_decode($response->getBody(), true);

            if(empty($userData)) {
                return [
                    'email' => 'You do not have permission to access this application.',
                ];
            }


            // Trigger afterLogin logic
            return $this->afterLogin($userData);

        } catch (RequestException $e) {
            return [
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
        return [
            'user' => $userData
        ];
//        session(['user' => $user]);
//        return [
//            'user' => $user,
//            'token' => $user->createToken('web-token', ["*"], now()->addWeek())->plainTextToken
//        ];
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect('/login');
    }
}