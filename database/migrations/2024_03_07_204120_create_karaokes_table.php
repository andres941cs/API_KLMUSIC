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
        Schema::create('karaokes', function (Blueprint $table) {
            $table->id();
            $table->string('settings', 10000);
            $table->boolean('isPublished');
            $table->date('publication_date');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_lyric');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_lyric')->references('id')->on('lyrics');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karaokes');
    }
};
