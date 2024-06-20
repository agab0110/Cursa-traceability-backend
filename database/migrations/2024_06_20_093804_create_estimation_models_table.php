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
        Schema::create('estimation_models', function (Blueprint $table) {
            $table->id();
            $table->double('height')->nullable();
            $table->double('volume')->nullable();
            $table->double('double_diameter')->nullable();
            $table->string('mesure');
            $table->string('formula');
            $table->string('retrurning_parameter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimation_models');
    }
};
