<?php

namespace LaravelLogin;

use Illuminate\Support\ServiceProvider;

class LaravelLoginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        if (config('laravel-login.api_enabled')) {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        }

        $this->publishes([
            __DIR__ . '/config/laravel-login.php' => config_path('laravel-login.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/laravel-login'),
        ], 'views');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/laravel-login.php',
            'laravel-login'
        );
    }
}