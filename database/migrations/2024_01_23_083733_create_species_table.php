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
        Schema::create('species', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("classification");
            $table->string("designation");
            $table->string("average_height");
            $table->string("average_lifespan");
            $table->string("eye_colors");
            $table->string("hair_colors");
            $table->string("skin_colors");
            $table->string("language");
            $table->unsignedBigInteger('homeworld');
            $table->timestamps();

            $table->foreign('homeworld')->references('id')->on('planets')->onDelete('cascade');
       
        });

        // Table de liaison avec films
        Schema::create('species_films', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('species_id');
            $table->unsignedBigInteger('film_id');
            $table->timestamps();

            $table->foreign('species_id')->references('id')->on('species')->onDelete('cascade');
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
        });

        // Table de liaison avec people
        Schema::create('species_people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('species_id');
            $table->unsignedBigInteger('people_id');
            $table->timestamps();

            $table->foreign('species_id')->references('id')->on('species')->onDelete('cascade');
            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('species_films');
        Schema::dropIfExists('species_people');
        Schema::dropIfExists('species');
    }
};
