<?php

namespace LaravelLogin;

use Illuminate\Support\ServiceProvider;

class LaravelLoginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-sso-login');

        if (config('laravel-sso-login.api_enabled')) {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        }

        $this->publishes([
            __DIR__ . '/config/laravel-sso-login.php' => config_path('laravel-sso-login.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/laravel-sso-login'),
        ], 'views');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/laravel-sso-login.php',
            'laravel-sso-login'
        );
    }
}