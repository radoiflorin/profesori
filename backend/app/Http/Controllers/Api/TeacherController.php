<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Teacher::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:100',
            'role' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $teacher = Teacher::create($data);

        return response()->json($teacher, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        return response()->json($teacher);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:100',
            'role' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $teacher->update($data);

        return response()->json($teacher);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return response()->json(null, 204);
    }
}
