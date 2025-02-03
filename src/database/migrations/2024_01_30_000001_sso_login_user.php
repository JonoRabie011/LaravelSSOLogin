<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    public function up()
    {
        Schema::connection(config('database.default'))->create('sso_users', function (Blueprint $table) {
            $table->id();
            $table->string('guuid')->unique();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('token');
            $table->string('refreshToken');
            $table->string('email')->unique();
            $table->timestamps();
        });
}

    public function down()
    {
        Schema::connection(config('database.default'))->dropIfExists('sso_users');
    }
};
