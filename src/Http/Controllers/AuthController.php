<?php

namespace LaravelLogin\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use LaravelLogin\Models\RolePermission;
use LaravelLogin\Models\SSOUser;

class AuthController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = config('laravel-sso-login.user_model', SSOUser::class);
    }

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

            if ($response->failed()) {
                return back()->withErrors(['message' => 'Invalid credentials.']);
            }

            $userData = $response->json();

            if (empty($userData)) {
                return back()->withErrors(['message' => 'You do not have permission to access this application.']);
            }

            return $this->afterLogin($userData);

        } catch (RequestException $e) {
            return back()->withErrors(['message' => 'Invalid credentials.']);
        }
    }

    protected function afterLogin($userData)
    {
        $userModel = $this->userModel;

        $user = $userModel::updateOrCreate(
            ['guuid' => $userData['guuid']],
            [
                'firstName' => $userData['firstName'],
                'lastName' => $userData['lastName'],
                'guuid' => $userData['guuid'],
                'token' => $userData['token'],
                'refreshToken' => $userData['refreshToken'],
            ]
        );

        $role = $userData['subscription']['subscriptionPackage']['associatedRole'];
        $permissions = json_decode(base64_decode(substr($role['permissions'], 5)), true);

        DB::transaction(function () use ($user, $permissions, $role) {
            $user->roles()->whereNotIn('name', $permissions)->delete();

            foreach ($permissions as $permission) {
                RolePermission::updateOrCreate(
                    [
                        'name' => $role['name'],
                        'permission' => $permission,
                        'user_id' => $user->id
                    ],
                    [
                        'permission' => $permission
                    ]
                );
            }
        });

        // Handle custom login callback
        if ($callback = config('laravel-sso-login.after_login_callback')) {
            return call_user_func($callback, $user);
        }

        session(['user' => $userData]);
        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        if ($callback = config('laravel-sso-login.logout_callback')) {
            return call_user_func($callback, $request);
        }

        $request->session()->forget('user');
        return redirect('/login');
    }
}
