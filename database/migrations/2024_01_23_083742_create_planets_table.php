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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planets');
    }
};
