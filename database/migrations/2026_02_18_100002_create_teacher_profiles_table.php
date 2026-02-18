<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');

            // Personal info
            $table->string('cnp')->nullable()->unique();
            $table->email('email')->nullable();
            $table->string('phone_personal')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable(); // M, F
            $table->string('civil_status')->nullable(); // Single, Married, Divorced, Widowed

            // Address
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('county')->nullable();
            $table->string('postal_code')->nullable();

            // Education
            $table->string('specialization_1')->nullable();
            $table->string('specialization_2')->nullable();
            $table->string('specialization_3')->nullable();
            $table->string('university')->nullable();
            $table->integer('graduation_year')->nullable();

            // Employment
            $table->integer('teaching_hours_per_week')->default(0);
            $table->string('framing_mode')->nullable(); // TC, CD, etc
            $table->date('employment_date')->nullable();
            $table->string('school_assignment')->nullable();

            // Notes
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_profiles');
    }
};
