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
        Schema::table('movies', function (Blueprint $table) {
            $table->string('rated_type')->nullable();
            $table->string('director')->nullable();
            $table->string('wrtitter')->nullable();
            $table->string('production')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColunm('rated_type');
            $table->dropColunm('director');
            $table->dropColunm('wrtitter');
            $table->dropColunm('production');
        });
    }
};
