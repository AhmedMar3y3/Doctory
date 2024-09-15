<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();  // Admin code field
            $table->boolean('is_used')->default(false);  // Status to check if it's used
            $table->timestamps();
        });

        // Insert admin codes directly in the migration
        DB::table('admin_codes')->insert([
            ['code' => 'ABC123', 'is_used' => false],
            ['code' => 'XYZ789', 'is_used' => false],
            ['code' => 'MAR313', 'is_used' => false],
            // Add more codes if necessary
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_codes');
    }
};
