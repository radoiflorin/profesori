<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create sample teachers and timetables for development
        $t1 = \App\Models\Teacher::create([ 'name' => 'Daria Petrescu', 'subject' => 'Matematica', 'phone' => '0733440120', 'role' => 'Coordonator' ]);
        $t2 = \App\Models\Teacher::create([ 'name' => 'Andrei Luca', 'subject' => 'Limba Romana', 'phone' => '0721330765', 'role' => 'Titular' ]);
        $t3 = \App\Models\Teacher::create([ 'name' => 'Ioana Mihai', 'subject' => 'Biologie', 'phone' => '0722180332', 'role' => 'Asociat' ]);

        \App\Models\Timetable::create([ 'teacher_id' => $t1->id, 'day' => 'Luni', 'start_time' => '08:00', 'end_time' => '09:30', 'class' => '9A', 'room' => '12' ]);
        \App\Models\Timetable::create([ 'teacher_id' => $t2->id, 'day' => 'Marti', 'start_time' => '10:00', 'end_time' => '11:30', 'class' => '10B', 'room' => 'Aula' ]);
        \App\Models\Timetable::create([ 'teacher_id' => $t3->id, 'day' => 'Miercuri', 'start_time' => '09:45', 'end_time' => '11:15', 'class' => '11A', 'room' => 'Lab' ]);
    }
}
