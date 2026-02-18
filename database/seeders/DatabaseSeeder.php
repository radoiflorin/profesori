<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Timetable;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample teachers
        $teachers = [
            ['name' => 'Prof. Ion Popescu', 'subject' => 'Matematica', 'role' => 'Titular', 'phone' => '0733123456'],
            ['name' => 'Prof. Maria Ionescu', 'subject' => 'Limba Romana', 'role' => 'Coordonator', 'phone' => '0721987654'],
            ['name' => 'Prof. Gheorghe Georgescu', 'subject' => 'Informatica', 'role' => 'Asociat', 'phone' => '0745555555'],
            ['name' => 'Prof. Ana Vasilescu', 'subject' => 'Limba Engleza', 'role' => 'Titular', 'phone' => '0712345678'],
            ['name' => 'Prof. Mihai Stanescu', 'subject' => 'Fizica', 'role' => 'Suplinitor', 'phone' => '0700000000'],
            ['name' => 'Prof. Elena Dumitrescu', 'subject' => 'Chimie', 'role' => 'Titular', 'phone' => '0755555555'],
        ];

        foreach ($teachers as $teacherData) {
            Teacher::create($teacherData);
        }

        // Create sample timetables
        $timetables = [
            ['teacher_id' => 1, 'day' => 'Luni', 'start_time' => '08:00', 'end_time' => '09:00', 'class' => '10A', 'room' => 'Sala 1'],
            ['teacher_id' => 2, 'day' => 'Luni', 'start_time' => '09:00', 'end_time' => '10:00', 'class' => '10B', 'room' => 'Sala 2'],
            ['teacher_id' => 3, 'day' => 'Marti', 'start_time' => '10:00', 'end_time' => '11:00', 'class' => '11A', 'room' => 'Lab 1'],
            ['teacher_id' => 4, 'day' => 'Marti', 'start_time' => '11:00', 'end_time' => '12:00', 'class' => '10C', 'room' => 'Sala 3'],
            ['teacher_id' => 5, 'day' => 'Miercuri', 'start_time' => '13:00', 'end_time' => '14:00', 'class' => '9A', 'room' => 'Lab 2'],
            ['teacher_id' => 6, 'day' => 'Joi', 'start_time' => '14:00', 'end_time' => '15:00', 'class' => '10D', 'room' => 'Sala 4'],
        ];

        foreach ($timetables as $timetableData) {
            Timetable::create($timetableData);
        }
    }
}
