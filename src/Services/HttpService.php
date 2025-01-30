<?php

namespace LaravelLogin\Services;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

Class HttpService
{
    private $client;

    public $ssoToken;
    public $ssoRefreshToken;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => config('laravel-login.sso_url')
        ]);
    }

    /**
     * @throws GuzzleException
     */
    function get($url, $customHeaders = []): ResponseInterface
    {

        $response = $this->client->get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . config('laravel-login.sso_application_token'),
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

    /**
     * @throws GuzzleException
     */
    function post($url, $body, $customHeaders = []): ResponseInterface
    {

        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . config('laravel-login.sso_application_token'),
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