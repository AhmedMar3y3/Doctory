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
        Schema::create('specializations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
        DB::table('specializations')->insert([
            ['name' => 'عظام'],
            ['name' => 'باطنة'],
            ['name' => 'أنف وأذن وحنجرة'],
            ['name' => 'جراحة'],
            ['name' => 'أسنان'],
            ['name' => 'نفسية'],
            ['name' => 'عيون'],
            ['name' => 'جلدية'],
            ['name' => 'أطفال'],
            ['name' => 'نساء وتوليد'],
            ['name' => 'علاج طبيعي'],
            
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specializations');
    }
};
