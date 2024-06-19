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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('summary');
            $table->string('genre');
            $table->date('release_date');
            $table->decimal('rating', 2, 1); // Store rating with two decimal places
            $table->string('image_poster')->nullable(); // Allow null values for poster
            $table->string('trailer')->nullable(); // Allow null values for trailer
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
