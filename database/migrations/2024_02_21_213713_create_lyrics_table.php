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
        Schema::create('lyrics', function (Blueprint $table) {
            $table->id();
            $table->string('lyric', 3000);
            $table->string('language',100);
            $table->unsignedBigInteger('id_song');
            $table->unsignedBigInteger('id_video');
            $table->foreign('id_song')->references('id')->on('songs');
            $table->foreign('id_video')->references('id')->on('videos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lyrics');
    }
};
