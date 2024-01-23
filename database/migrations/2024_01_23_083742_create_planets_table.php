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
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("diameter");
            $table->string("rotation_period");
            $table->string("orbital_period");
            $table->string("gravity");
            $table->string("population");
            $table->string("climate");
            $table->string("terrain");
            $table->string("surface_water");
            $table->timestamps();
        });

        // Table de liaison avec films
        Schema::create('planet_films', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('planet_id');
            $table->unsignedBigInteger('film_id');
            $table->timestamps();

            $table->foreign('planet_id')->references('id')->on('planets')->onDelete('cascade');
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
        });

        // Table de liaison avec people
        Schema::create('planet_people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('planet_id');
            $table->unsignedBigInteger('people_id');
            $table->timestamps();

            $table->foreign('planet_id')->references('id')->on('planets')->onDelete('cascade');
            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planet_films');
        Schema::dropIfExists('planet_people');
        Schema::dropIfExists('planets');
    }
};
