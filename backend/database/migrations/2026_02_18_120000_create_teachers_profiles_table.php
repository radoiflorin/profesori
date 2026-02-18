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
        Schema::create('teachers_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->unique()->constrained('teachers')->onDelete('cascade');

            // Personal Information
            $table->string('cnp')->nullable()->unique(); // Cod Numeric Personal
            $table->date('date_of_birth')->nullable();
            $table->string('birthplace')->nullable(); // Locality and County
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->string('father_initial')->nullable();

            // Professional Information
            $table->string('didactic_function')->nullable(); // e.g., "Profesor", "Lector"
            $table->string('specialization_1')->nullable(); // Primary specialization
            $table->string('specialization_2')->nullable(); // Secondary specialization
            $table->string('specialization_3')->nullable(); // Third specialization

            // Framing Information
            $table->enum('framing_mode', ['Titular', 'Suplinitor', 'Contractual', 'Pensionat'])->nullable();
            $table->string('decision_number')->nullable(); // Decizie Number
            $table->date('decision_date')->nullable(); // Data Emiterii
            $table->string('decision_issuer')->nullable(); // Emitentul Deciziei

            // Educational Information
            $table->string('faculty')->nullable(); // Faculty/School
            $table->integer('graduation_year')->nullable(); // Anul Absolvirii
            $table->string('university')->nullable(); // University Name
            $table->string('last_didactic_degree')->nullable(); // Ultimul Grad Didactic

            // Employment Information
            $table->integer('total_hours_per_week')->nullable(); // Număr Total de Ore
            $table->integer('teaching_core_hours')->nullable(); // Ore TC
            $table->integer('complementary_hours')->nullable(); // Ore CD
            $table->integer('other_hours')->nullable(); // Ore Alte Activități

            // Status
            $table->enum('civil_status', ['Necăsătorit', 'Căsătorit', 'Divorțat', 'Văduv'])->nullable();
            $table->boolean('available_for_consulting')->default(false);
            $table->boolean('is_pensioned')->default(false);

            // School Assignment
            $table->string('unit_with_legal_personality')->nullable(); // Unitatea de Învăţământ
            $table->string('locality')->nullable();
            $table->enum('environment', ['Urban', 'Rural'])->nullable();

            // Additional
            $table->text('notes')->nullable();
            $table->string('email')->nullable();
            $table->date('last_updated_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers_profiles');
    }
};
