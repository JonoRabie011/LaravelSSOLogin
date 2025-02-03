<?php

namespace LaravelLogin;

use Illuminate\Console\Command;

class UnInstallPackageCommand extends Command
{
    protected $signature = 'laravel-login:uninstall';
    protected $description = 'Uninstall the Laravel Login package and rollback migrations.';

    public function handle()
    {
        $this->info('Rolling back migrations...');
        $this->call('migrate:rollback', ['--force' => true]);

        $this->info('Package uninstalled successfully!');
    }
}