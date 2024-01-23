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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->integer("episode_id");
            $table->text("opening_crawl");
            $table->string("director");
            $table->string("producer");
            $table->date("release_date");
            $table->timestamps();
        });

         // Table de liaison avec people
         Schema::create('film_people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('film_id');
            $table->unsignedBigInteger('people_id');
            $table->timestamps();

            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');
        });

        // Table de liaison avec planets
        Schema::create('film_planets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('film_id');
            $table->unsignedBigInteger('planet_id');
            $table->timestamps();

            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->foreign('planet_id')->references('id')->on('planets')->onDelete('cascade');
        });

        // Table de liaison avec starships
        Schema::create('film_starships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('film_id');
            $table->unsignedBigInteger('starship_id');
            $table->timestamps();

            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->foreign('starship_id')->references('id')->on('starships')->onDelete('cascade');
        });

        // Table de liaison avec vehicles
        Schema::create('film_vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('film_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->timestamps();

            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });

        // Table de liaison avec species
        Schema::create('film_species', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('film_id');
            $table->unsignedBigInteger('species_id');
            $table->timestamps();

            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->foreign('species_id')->references('id')->on('species')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_people');
        Schema::dropIfExists('film_planets');
        Schema::dropIfExists('film_starships');
        Schema::dropIfExists('film_vehicles');
        Schema::dropIfExists('film_species');
        Schema::dropIfExists('films');
    }
};
