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
            $table->string('lyric_romaji', 3000);
            $table->string('url', 2083);
            $table->unsignedBigInteger('id_song');
            $table->foreign('id_song')->references('id')->on('songs');
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
