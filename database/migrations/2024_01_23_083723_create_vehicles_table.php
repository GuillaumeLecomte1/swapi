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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("model");
            $table->string("vehicle_class");
            $table->string("manufacturer");
            $table->string("cost_in_credits");
            $table->integer("length");
            $table->string("crew");
            $table->string("passengers");
            $table->string("max_atmosphering_speed");
            $table->string("cargo_capacity");
            $table->string("consumables");
            $table->timestamps();
        });

        // Table de liaison avec films
        Schema::create('vehicle_films', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('film_id');
            $table->timestamps();

            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
        });

        // Table de liaison avec people
        Schema::create('vehicle_people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('people_id');
            $table->timestamps();

            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('people_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_films');
        Schema::dropIfExists('vehicle_people');
        Schema::dropIfExists('vehicles');
    }
};
