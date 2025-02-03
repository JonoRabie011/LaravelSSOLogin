<?php

namespace LaravelLogin;

use Illuminate\Console\Command;

class InstallPackageCommand extends Command
{
    protected $signature = 'laravel-login:install';
    protected $description = 'Install the Laravel Login package and run migrations.';

    public function handle()
    {
        $this->info('Running migrations...');
        $this->call('migrate', ['--force' => true]);

        $this->info('Package installed successfully!');
    }
}