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


    use PermissionService;

}