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
            $table->boolean('isInstrumental');
            $table->string('url', 2083);
            $table->string('preview', 2083)->nullable();
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
