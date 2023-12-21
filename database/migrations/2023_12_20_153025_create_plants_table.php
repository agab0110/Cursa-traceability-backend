<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->double('lat');
            $table->double('lng');
            $table->integer('particle')->nullable();
            $table->string('woody_species');
            $table->double('diameter');
            $table->double('height')->nullable();
            $table->string('cultivar')->nullable();
            $table->string('propagation')->nullable();
            $table->date('georeferenzial_date');
            $table->string('notes')->nullable();
            $table->boolean('hammered')->default(false);
            $table->foreignId('forest_id')->constrained()->nullable()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plants');
    }
};
