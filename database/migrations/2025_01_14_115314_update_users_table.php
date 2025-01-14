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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'login');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('login', 100)->change();
            $table->string('email', 100)->change();
            $table->string('password', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->change();
            $table->string('email')->change();
            $table->string('login')->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('login', 'name');
        });
    }
};
