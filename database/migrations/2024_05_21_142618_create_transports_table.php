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
        Schema::create('transports', function (Blueprint $table) {
            $table->id();
            $table->string('plate');
            $table->string('driver');
            $table->string('company');
            $table->foreignId('lot_id')->constrained();
            $table->foreignId('pre_production_id')->constrained()->nullable();
            $table->foreignId('production_id')->constrained()->nullable();
            $table->boolean('shipping');
            $table->date('shipping_date');
            $table->boolean('shipped')->default(false);
            $table->date('shipped_date')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transports');
    }
};
