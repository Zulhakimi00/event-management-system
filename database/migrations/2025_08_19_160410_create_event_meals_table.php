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
        Schema::create('event_meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('remark')->nullable();
            $table->integer('total_pax')->default(0);
            $table->integer('total_vegetarian_meal')->default(0);
            $table->foreignId('special_guest_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('serving_method_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('status')->default(0); // 0 - pending 1 - aprove
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_meals');
    }
};
