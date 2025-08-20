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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // relation ke department
            $table->foreignId('department_id')
                ->constrained('departments')
                ->cascadeOnDelete();

            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');

            $table->integer('status')->default(1); // contoh: 0 = cancel, 1 = confirmed
            $table->string('contact_no')->nullable();
            // relation ke location
            $table->foreignId('location_id')
                ->constrained('locations')
                ->cascadeOnDelete();
            $table->foreignId('event_type_id')
                ->constrained('event_types')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
