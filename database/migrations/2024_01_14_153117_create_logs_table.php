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
        Schema::create('logs', function (Blueprint $table) {
            $table->integer('number');
            $table->foreignId('lot_id')->constrained()->nullable()->cascadeOnDelete();
            $table->double('lenght');
            $table->double('median');
            $table->date('cut_date');
            $table->timestamps();

            $table->primary(['number', 'plant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
