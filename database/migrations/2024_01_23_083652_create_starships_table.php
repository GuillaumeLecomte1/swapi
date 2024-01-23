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
        Schema::create('starships', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("model");
            $table->string("starship_class");
            $table->string("manufacturer");
            $table->string("cost_in_credits");
            $table->integer("length");
            $table->string("crew");
            $table->string("passengers");
            $table->string("max_atmosphering_speed");
            $table->string("hyperdrive_rating");
            $table->string("MGLT");
            $table->string("cargo_capacity");
            $table->string("consumables");
            $table->timestamps();
        });

        // Table de liaison avec films
        Schema::create('starship_films', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('starship_id');
            $table->unsignedBigInteger('film_id');
            $table->timestamps();

            $table->foreign('starship_id')->references('id')->on('starships')->onDelete('cascade');
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
        });

        // Table de liaison avec people
        Schema::create('starship_people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('starship_id');
            $table->unsignedBigInteger('people_id');
            $table->timestamps();

            $table->foreign('starship_id')->references('id')->on('starships')->onDelete('cascade');
            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('starship_films');
        Schema::dropIfExists('starship_people');
        Schema::dropIfExists('starships');
    }
};
