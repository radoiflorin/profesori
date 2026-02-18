<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    // Display all timetables
    public function index()
    {
        $timetables = Timetable::with('teacher')->orderBy('day')->orderBy('start_time')->paginate(20);
        $days = ['Luni', 'Marti', 'Miercuri', 'Joi', 'Vineri'];
        return view('timetables.index', compact('timetables', 'days'));
    }

    // Show create form
    public function create()
    {
        $teachers = Teacher::all();
        $days = ['Luni', 'Marti', 'Miercuri', 'Joi', 'Vineri'];
        return view('timetables.create', compact('teachers', 'days'));
    }

    // Store timetable entry
    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'class' => 'nullable|string|max:10',
            'room' => 'nullable|string|max:50'
        ]);

        Timetable::create($validated);

        return redirect()->route('timetables.index')
                        ->with('success', 'Ora adaugata cu succes!');
    }

    // Show edit form
    public function edit(Timetable $timetable)
    {
        $teachers = Teacher::all();
        $days = ['Luni', 'Marti', 'Miercuri', 'Joi', 'Vineri'];
        return view('timetables.edit', compact('timetable', 'teachers', 'days'));
    }

    // Update timetable
    public function update(Request $request, Timetable $timetable)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'class' => 'nullable|string|max:10',
            'room' => 'nullable|string|max:50'
        ]);

        $timetable->update($validated);

        return redirect()->route('timetables.index')
                        ->with('success', 'Ora actualizata cu succes!');
    }

    // Delete timetable entry
    public function destroy(Timetable $timetable)
    {
        $timetable->delete();

        return redirect()->route('timetables.index')
                        ->with('success', 'Ora stearsa cu succes!');
    }

    // Get teacher's timetable
    public function byTeacher(Teacher $teacher)
    {
        $timetables = $teacher->timetables()->orderBy('day')->orderBy('start_time')->get();
        return view('timetables.by-teacher', compact('teacher', 'timetables'));
    }
}
