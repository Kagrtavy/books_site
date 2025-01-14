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
            $table->string('name', 100);
            $table->string('photo', 255);
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['Original work', 'Based on']);
            $table->enum('authorship', ['The work of your authorship', 'Translation']);
            $table->string('author', 150)->nullable();
            $table->string('work_link', 255)->nullable();
            $table->unsignedBigInteger('source_id');
            $table->unsignedBigInteger('rating_id');
            $table->enum('size', ['min', 'mid', 'max']);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');
            $table->foreign('rating_id')->references('id')->on('ratings')->onDelete('cascade');
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
