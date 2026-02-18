<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->string('day'); // Luni, Marti, Miercuri, Joi, Vineri
            $table->time('start_time');
            $table->time('end_time');
            $table->string('class')->nullable(); // e.g., "10A", "11B"
            $table->string('room')->nullable(); // e.g., "Sala 5", "Lab 1"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
