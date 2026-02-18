<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'role',
        'phone',
        'notes'
    ];

    public function timetables(): HasMany
    {
        return $this->hasMany(Timetable::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(TeacherProfile::class);
    }
}
