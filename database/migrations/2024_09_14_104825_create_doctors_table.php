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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('price')->nullable();
            $table->text('details')->nullable();
            $table->string('waiting_time')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreignId('specialization_id')->references('id')->on('specializations')->onDelete('cascade');
            $table->json('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
