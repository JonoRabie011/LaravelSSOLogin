<?php

namespace LaravelLogin\Services;

class LarvelSingleSignOn extends HttpService
{

    public $ssoToken;
    public $ssoRefreshToken;

    public function __construct($ssoToken, $ssoRefreshToken)
    {
        $this->ssoToken = $ssoToken;
        $this->ssoRefreshToken = $ssoRefreshToken;

        parent::__construct();
    }

    /**
     * Convert a string to camel case
     * @param $stringToConvert
     * @return string
     */
    private function camel_case($stringToConvert): string
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower($stringToConvert))));
    }

    /**
     * Convert a string to snake case
     * @param $stringToConvert
     * @return string
     */
    private function snake_case($stringToConvert): string
    {
        return str_replace(' ', '_', strtolower($stringToConvert));
    }


    use PermissionService;

}