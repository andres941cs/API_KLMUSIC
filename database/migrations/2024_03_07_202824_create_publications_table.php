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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->boolean('isPublished');
            $table->timestamp('publication_date');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_karaoke');
            $table->foreignId('id_user')->references('id')->on('users');
            $table->foreignId('id_karaoke')->references('id')->on('karaokes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
