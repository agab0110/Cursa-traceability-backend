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
        Schema::create('log_sections', function (Blueprint $table) {
            $table->foreignId('lot_id')->constrained();
            $table->integer('log_number');
            $table->integer('section');
            $table->foreign(['log_number', 'lot_id'])
                    ->references(['number', 'lot_id'])
                    ->on('logs')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_sections');
    }
};
