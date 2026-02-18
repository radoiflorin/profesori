<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherProfile extends Model
{
    use SoftDeletes;

    protected $table = 'teachers_profiles';

    protected $fillable = [
        'teacher_id',
        // Personal
        'cnp',
        'date_of_birth',
        'birthplace',
        'gender',
        'father_initial',
        // Professional
        'didactic_function',
        'specialization_1',
        'specialization_2',
        'specialization_3',
        // Framing
        'framing_mode',
        'decision_number',
        'decision_date',
        'decision_issuer',
        // Educational
        'faculty',
        'graduation_year',
        'university',
        'last_didactic_degree',
        // Employment
        'total_hours_per_week',
        'teaching_core_hours',
        'complementary_hours',
        'other_hours',
        // Status
        'civil_status',
        'available_for_consulting',
        'is_pensioned',
        // School
        'unit_with_legal_personality',
        'locality',
        'environment',
        // Additional
        'notes',
        'email',
        'last_updated_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'decision_date' => 'date',
        'last_updated_at' => 'date',
        'available_for_consulting' => 'boolean',
        'is_pensioned' => 'boolean',
        'total_hours_per_week' => 'integer',
        'teaching_core_hours' => 'integer',
        'complementary_hours' => 'integer',
        'other_hours' => 'integer',
        'graduation_year' => 'integer',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Teacher::class);
    }

    /**
     * Calculate total teaching hours
     */
    public function getTotalHoursAttribute(): int
    {
        return ($this->teaching_core_hours ?? 0) +
               ($this->complementary_hours ?? 0) +
               ($this->other_hours ?? 0);
    }

    /**
     * Get all specializations as array
     */
    public function getSpecializationsAttribute(): array
    {
        return array_filter([
            $this->specialization_1,
            $this->specialization_2,
            $this->specialization_3,
        ]);
    }

    /**
     * Calculate years of experience (based on graduation year)
     */
    public function getExperienceYearsAttribute(): ?int
    {
        if (!$this->graduation_year) return null;
        return now()->year - $this->graduation_year;
    }
}
