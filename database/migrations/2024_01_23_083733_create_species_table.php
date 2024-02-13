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
            $table->timestamp('edited');
            $table->string("classification");
            $table->string("name");
            $table->string("designation");
            $table->timestamp('created');
            $table->string("eye_colors");
            $table->string("skin_colors");
            $table->string("language");
            $table->string("hair_colors");
            $table->unsignedBigInteger('homeworld');
            $table->string("average_lifespan");
            $table->string("average_height");
            $table->id();

            $table->foreign('homeworld')->references('id')->on('planets')->onDelete('cascade');
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('species');
    }
};
