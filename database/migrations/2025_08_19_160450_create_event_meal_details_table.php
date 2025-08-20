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
        Schema::create('event_meal_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_meal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('meal_session_id')->constrained()->cascadeOnDelete();
            $table->time('time')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_meal_details');
    }
};
