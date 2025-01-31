<?php

namespace LaravelLogin;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use LaravelLogin\Services\LarvelSingleSignOn;
use LaravelLogin\Services\PermissionService;

class LaravelLoginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (config('laravel-sso-login.api_enabled')) {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        }

        $this->publishes([
            __DIR__ . '/config/laravel-sso-login.php' => config_path('laravel-sso-login.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/laravel-sso-login'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations'),
        ], 'sso-migrations');

        $this->publishes([
            __DIR__ . '/resources/css' => public_path('vendor/laravel-sso-login/css'),
        ], 'public');

        if(config('laravel-sso-login.api_enabled')) {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        } else {
            $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        }

        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-sso-login');

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');


        /*
         * Setup the database
         */

        $this->setupDatabase();

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    protected function setupDatabase()
    {
        $customConnection = config('laravel-sso-login.database_connection');

        if ($customConnection) {
            // Use user-specified database connection
            Config::set('database.default', $customConnection);
        } else {
            try {
                DB::connection()->getPdo();
            } catch (\Exception $e) {
                $this->useSQLite();
            }
        }
    }

    protected function useSQLite()
    {
        $databasePath = storage_path('app/sso_database.sqlite');

        // Ensure the SQLite file exists
        if (!File::exists($databasePath)) {
            File::put($databasePath, '');
        }

        // Dynamically set SQLite as the database connection
        Config::set('database.connections.sso_sqlite', [
            'driver' => 'sqlite',
            'database' => $databasePath,
            'prefix' => '',
        ]);

        // Set the default connection to SQLite
        Config::set('database.default', 'sso_sqlite');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/laravel-sso-login.php',
            'laravel-sso-login'
        );

        $this->app->singleton(LarvelSingleSignOn::class, function () {
            return new LarvelSingleSignOn();
        });
    }
}