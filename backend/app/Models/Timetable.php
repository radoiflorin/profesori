<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timetable extends Model
{
    protected $fillable = ['teacher_id', 'day', 'start_time', 'end_time', 'class', 'room'];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Teacher::class);
    }
}
