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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('duration');
            $table->string('genre');
            $table->string('image');
            $table->unsignedBigInteger('id_artist');
            $table->unsignedBigInteger('id_album')->nullable();
            $table->foreign('id_artist')->references('id')->on('artists');
            $table->foreign('id_album')->references('id')->on('albums');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
