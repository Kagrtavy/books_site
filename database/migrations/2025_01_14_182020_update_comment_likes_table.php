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
        Schema::table('comment_likes', function (Blueprint $table) {
            $table->dropForeign(['publication_id']);
            $table->dropColumn('publication_id');

            $table->unsignedBigInteger('comment_id')->after('id');
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comment_likes', function (Blueprint $table) {
            $table->dropForeign(['comment_id']);
            $table->dropColumn('comment_id');

            $table->unsignedBigInteger('publication_id')->after('id');
            $table->foreign('publication_id')->references('id')->on('publications')->onDelete('cascade');
        });
    }
};
