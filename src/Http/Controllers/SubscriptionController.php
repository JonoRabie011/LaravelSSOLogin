<?php

namespace LaravelLogin\Http\Controllers;

use Illuminate\Routing\Controller;

class SubscriptionController extends Controller
{

    public function showPricing()
    {

        try {
            $response = $this->getSubscriptionPackages();
            $pricing = json_decode($response->getBody()->getContents(), true);
            return view('laravel-sso-login::subscription-packages', compact('pricing'));
        } catch (\Exception $e) {
            return view('laravel-sso-login::subscription-packages', compact('pricing'));
        }
    }

    public function getSubscriptionPackages(): \Psr\Http\Message\ResponseInterface
    {
        $client = new \GuzzleHttp\Client();
        return $client->get(config('laravel-sso-login.sso_url') . "/subscription/packages", [
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