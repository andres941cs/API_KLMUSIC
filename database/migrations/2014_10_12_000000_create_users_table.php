<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role')->default('guest');//unverified_user
            $table->string('image')->default('images/users/default.jpg');
            $table->rememberToken();// FUNCION -> string('token', 1000)->nullable();
            $table->timestamps();
            # CAMPO PARA SABER CUANDO FUE LA ULTIMA VERIFICACION DEL CORREO
            //$table->timestamp('email_verified_at')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
