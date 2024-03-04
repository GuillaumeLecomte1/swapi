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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->timestamp("edited");
            $table->string("name");
            $table->timestamp("created");
            $table->string("gender");
            $table->string("skin_color");
            $table->string("hair_color");
            $table->integer("height");
            $table->string("eye_color");
            $table->integer("mass");
            $table->unsignedBigInteger('homeworld');
            $table->string("birth_year");

            $table->foreign('homeworld')->references('id')->on('planets')->onDelete('cascade');
        });

        // Table de liaison avec films
        Schema::create('people_films', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('people_id');
            $table->unsignedBigInteger('film_id');
            $table->timestamps();

            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
        });

        // Table de liaison avec species
        Schema::create('people_species', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('species_id');
            $table->unsignedBigInteger('people_id');
            $table->timestamps();

            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('species_id')->references('id')->on('species')->onDelete('cascade');
        });

        // Table de liaison avec vehicles
        Schema::create('people_vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('people_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->timestamps();
        
            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });

        // Table de liaison avec starships
        Schema::create('people_starships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('people_id');
            $table->unsignedBigInteger('starship_id');
            $table->timestamps();
        
            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('starship_id')->references('id')->on('starships')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people_starships');
        Schema::dropIfExists('people_vehicles');
        Schema::dropIfExists('people_films');
        Schema::dropIfExists('people_planets');
        Schema::dropIfExists('people_species');
        Schema::dropIfExists('people');    }
};
