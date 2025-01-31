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

//        dd("token:". config('laravel-sso-login.sso_application_token'));
//        $this->client = Http::class;
    }

    private function buildUri($url): string
    {
        return config('laravel-sso-login.sso_url') . $url;
    }


    function get($url, $customHeaders = [])
    {

        $uri = $this->buildUri($url);
        $response = Http::withHeaders([
            ...$this->getTokenHeader(),
            ...$customHeaders
        ])->get($uri);

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

        $response = Http::withHeaders([
            ...$this->getTokenHeader(),
            ...$customHeaders
        ])->post($uri, [
            'body' => json_encode($body)
        ]);

        if($response->getStatusCode() == 403) {
            $this->refreshToken();
        }

        if ($response->getStatusCode() == 200) {
            $this->saveToken(
                $response->getHeader(strtolower('SSO-USER-TOKEN'))[0],
                $response->getHeader(strtolower('SSO-REFRESH-TOKEN'))[0]
            );
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
            "Authorization" => "Bearer " . config('laravel-sso-login.sso_application_token'),
            strtolower("SSO-USER-TOKEN") => $this->ssoToken,
            strtolower("SSO-REFRESH-TOKEN") => $this->ssoRefreshToken
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
        $response = $client->post(config('laravel-sso-login.sso_url') . "/refresh", [
            'headers' => [
                'Authorization' => 'Bearer ' . config('laravel-sso-login.sso_application_token'),
                ...$this->getTokenHeader()
            ]
        ]);
    }


}
