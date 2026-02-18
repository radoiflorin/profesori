<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Timetable;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // Display all teachers
    public function index()
    {
        $teachers = Teacher::with('profile', 'timetables')->paginate(15);
        return view('teachers.index', compact('teachers'));
    }

    // Show create form
    public function create()
    {
        $roles = ['Titular', 'Coordonator', 'Asociat', 'Suplinitor'];
        $subjects = ['Matematica', 'Limba Romana', 'Limba Engleza', 'Fizica', 'Chimie', 'Biologie', 'Informatica', 'Istorie', 'Geografie'];
        return view('teachers.create', compact('roles', 'subjects'));
    }

    // Store teacher
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:100',
            'role' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string'
        ]);

        $teacher = Teacher::create($validated);

        return redirect()->route('teachers.index')
                        ->with('success', 'Profesor adaugat cu succes!');
    }

    // Show teacher profile
    public function show(Teacher $teacher)
    {
        $teacher->load('profile', 'timetables');
        return view('teachers.show', compact('teacher'));
    }

    // Show edit form
    public function edit(Teacher $teacher)
    {
        $roles = ['Titular', 'Coordonator', 'Asociat', 'Suplinitor'];
        $subjects = ['Matematica', 'Limba Romana', 'Limba Engleza', 'Fizica', 'Chimie', 'Biologie', 'Informatica', 'Istorie', 'Geografie'];
        return view('teachers.edit', compact('teacher', 'roles', 'subjects'));
    }

    // Update teacher
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:100',
            'role' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string'
        ]);

        $teacher->update($validated);

        return redirect()->route('teachers.show', $teacher)
                        ->with('success', 'Profesor actualizat cu succes!');
    }

    // Delete teacher
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('teachers.index')
                        ->with('success', 'Profesor sters cu succes!');
    }

    // Show profile edit form
    public function editProfile(Teacher $teacher)
    {
        $profile = $teacher->profile ?? $teacher->profile()->make();
        return view('teachers.profile-edit', compact('teacher', 'profile'));
    }

    // Save profile
    public function saveProfile(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'cnp' => 'nullable|string|unique:teacher_profiles,cnp,' . $teacher->profile?->id,
            'email' => 'nullable|email',
            'phone_personal' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string',
            'civil_status' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'county' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'specialization_1' => 'nullable|string',
            'specialization_2' => 'nullable|string',
            'specialization_3' => 'nullable|string',
            'university' => 'nullable|string',
            'graduation_year' => 'nullable|integer',
            'teaching_hours_per_week' => 'nullable|integer',
            'framing_mode' => 'nullable|string',
            'employment_date' => 'nullable|date',
            'school_assignment' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $validated['teacher_id'] = $teacher->id;
        \App\Models\TeacherProfile::updateOrCreate(
            ['teacher_id' => $teacher->id],
            $validated
        );

        return redirect()->route('teachers.show', $teacher)
                        ->with('success', 'Profil actualizat cu succes!');
    }
}
