<?php

namespace LaravelLogin\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class SubscriptionController extends Controller
{

    public function showPricing()
    {

        try {
            $response = $this->getSubscriptionPackages();
            $pricing = json_decode($response->json(), true);
            return view('laravel-sso-login::subscription-packages', compact('pricing'));
        } catch (\Exception $e) {
            return view('laravel-sso-login::subscription-packages', compact('pricing'));
        }
    }

    /**
     * Function to fetch subscription packages from the SSO server
     */
    public function getSubscriptionPackages()
    {
        return Http::withToken(config('laravel-sso-login.sso_application_token'))
            ->get(config('laravel-sso-login.sso_url') . "/subscription/packages", [
            'headers' => [
                'Authorization' => 'Bearer ' . config('laravel-sso-login.sso_application_token')
            ]
        ]);
    }

    public function subscribe()
    {
        // Subscribe the user
    }

}