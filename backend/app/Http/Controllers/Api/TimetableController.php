<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Timetable::with('teacher')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|string|max:50',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'class' => 'nullable|string|max:100',
            'room' => 'nullable|string|max:100',
        ]);

        $timetable = Timetable::create($data);

        return response()->json($timetable, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Timetable $timetable)
    {
        return response()->json($timetable->load('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Timetable $timetable)
    {
        $data = $request->validate([
            'teacher_id' => 'sometimes|required|exists:teachers,id',
            'day' => 'nullable|string|max:50',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'class' => 'nullable|string|max:100',
            'room' => 'nullable|string|max:100',
        ]);

        $timetable->update($data);

        return response()->json($timetable->load('teacher'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timetable $timetable)
    {
        $timetable->delete();

        return response()->json(null, 204);
    }
}
