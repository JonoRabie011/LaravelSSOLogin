<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::connection(config('database.default'))->create('sso_roles_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('permission')->nullable();
            $table->foreignId('user_id')->constrained('sso_users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection(config('database.default'))::dropIfExists('sso_roles_permissions');
    }
};
