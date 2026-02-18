<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherProfile extends Model
{
    protected $table = 'teacher_profiles';

    protected $fillable = [
        'teacher_id',
        'cnp',
        'email',
        'phone_personal',
        'birth_date',
        'gender',
        'civil_status',
        'address',
        'city',
        'county',
        'postal_code',
        'specialization_1',
        'specialization_2',
        'specialization_3',
        'university',
        'graduation_year',
        'teaching_hours_per_week',
        'framing_mode',
        'employment_date',
        'school_assignment',
        'notes'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'employment_date' => 'date',
        'teaching_hours_per_week' => 'integer'
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
