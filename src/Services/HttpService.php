<?php

namespace LaravelLogin\Services;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use LaravelLogin\Models\SSOUser;
use Psr\Http\Message\ResponseInterface;

Class HttpService
{
    private $client;

    public $ssoToken;
    public $ssoRefreshToken;

    public function __construct()
    {
        $this->client = Http::withToken(config('laravel-login.sso_application_token'));
    }

    private function buildUri($url): string
    {
        return config('laravel-login.sso_url') . $url;
    }


    function get($url, $customHeaders = [])
    {

        $uri = $this->buildUri($url);

        $response = $this->client->get($uri, [
            'headers' => [
                ...$this->getTokenHeader(),
                ...$customHeaders
            ]]);

        if($response->getStatusCode() == 401) {
            $this->refreshToken();
        }

        if ($response->getStatusCode() == 200) {
            $this->saveToken($response->getHeader('SSO-USER-TOKEN')[0], $response->getHeader('SSO-REFRESH-TOKEN')[0]);
        }

        return $response;
    }


    function post($url, $body, $customHeaders = [])
    {

        $uri = $this->buildUri($url);

        $response = $this->client->post($uri, [
            'headers' => [
                ...$this->getTokenHeader(),
                ...$customHeaders
            ],
            'body' => json_encode($body)
        ]);

        if($response->getStatusCode() == 403) {
            $this->refreshToken();
        }

        if ($response->getStatusCode() == 200) {
            $this->saveToken($response->getHeader('SSO-USER-TOKEN')[0], $response->getHeader('SSO-REFRESH-TOKEN')[0]);
        }

        return $response;
    }



    public function getTokenHeader(): array
    {

        if (empty($this->ssoToken)) {
            $user = SSOUser::where('email', )->first();

            if($user) {
                $this->ssoToken = $user->token;
                $this->ssoRefreshToken = $user->refreshToken;
            }
        }

        return [
            "SSO-USER-TOKEN" => $this->ssoToken,
            "SSO-REFRESH-TOKEN" => $this->ssoRefreshToken
        ];
    }

    public function setToken($ssoToken, $ssoRefreshToken)
    {
        $this->ssoToken = $ssoToken;
        $this->ssoRefreshToken = $ssoRefreshToken;
    }

    private function saveToken($ssoToken, $ssoRefreshToken)
    {
        //@TODO save token to session?? Or cache

        $this->setToken($ssoToken, $ssoRefreshToken);
    }

    public function refreshToken()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->post(config('laravel-login.sso_url') . "/refresh", [
            'headers' => [
                'Authorization' => 'Bearer ' . config('laravel-login.sso_application_token'),
                ...$this->getTokenHeader()
            ]
        ]);
    }


}