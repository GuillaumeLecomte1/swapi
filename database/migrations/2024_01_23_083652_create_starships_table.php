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
            $table->string("crew");
            $table->string("passengers");
            $table->string("max_atmosphering_speed");
            $table->string("hyperdrive_rating");
            $table->string("MGLT");
            $table->string("cargo_capacity");
            $table->string("consumables");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('starships');
    }
};
