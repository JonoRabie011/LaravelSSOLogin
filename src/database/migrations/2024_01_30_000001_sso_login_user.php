<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up()
    {
        $userTable = config('laravel-sso-login.user_table', 'sso_users');
        $db = Schema::connection(config('database.default'));

        // Create table if it doesn't exist
        if (!$db->hasTable($userTable)) {
            $db->create($userTable, function (Blueprint $table) {
                $table->id();
                $table->string('guuid')->unique();
                $table->string('firstName');
                $table->string('lastName');
                $table->string('token');
                $table->string('refreshToken');
                $table->string('email')->unique();
                $table->string('externalId')->nullable()->unique();
                $table->timestamps();
            });
        } else {
            // Modify existing table to add missing columns
            $columns = Schema::getColumnListing($userTable);

            $db->table($userTable, function (Blueprint $table) use ($columns) {
                if (!in_array('refreshToken', $columns)) {
                    $table->string('refreshToken')->nullable();
                }

                if (!in_array('token', $columns)) {
                    $table->string('token')->nullable();
                }

                if (!in_array('guuid', $columns)) {
                    $table->string('guuid')->unique()->nullable();
                }
            });
        }
    }

    public function down()
    {
        $userTable = config('laravel-sso-login.user_table', 'sso_users');
        Schema::connection(config('database.default'))->dropIfExists($userTable);
    }
};