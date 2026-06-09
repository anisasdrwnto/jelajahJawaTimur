<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(){
        Schema::create('mst_users', function (Blueprint $table) {
            $table->string('mus_id_users', 30)->primary();
            $table->string('mus_name', 50);
            $table->string('mus_email', 255)->unique();
            $table->string('mus_password', 255);
            $table->string('mus_foto_profile', 100)->nullable();
            $table->string('mus_role', 30)->default('USR');
            $table->string('mus_createBy', 50)->default('System');
            $table->datetime('mus_createDate')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
