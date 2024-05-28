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
        Schema::create('returning_transports', function (Blueprint $table) {
            $table->foreignId('transport_id')->constrained();
            $table->string('notes');
            $table->date('returning_date');
            $table->date('returned_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returning_transports');
    }
};
