<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = ['name', 'subject', 'phone', 'role', 'notes'];

    public function timetables(): HasMany
    {
        return $this->hasMany(\App\Models\Timetable::class);
    }
}
