<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeacherProfile;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherProfileController extends Controller
{
    /**
     * Get profile for a teacher
     */
    public function show(Teacher $teacher)
    {
        $profile = $teacher->profile()->with('teacher')->first();

        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found',
                'data' => null
            ], 404);
        }

        return response()->json($profile);
    }

    /**
     * Create or update teacher profile
     */
    public function store(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'cnp' => 'nullable|string|unique:teachers_profiles,cnp',
            'date_of_birth' => 'nullable|date',
            'birthplace' => 'nullable|string|max:255',
            'gender' => 'nullable|in:M,F',
            'father_initial' => 'nullable|string|max:1',
            'didactic_function' => 'nullable|string|max:255',
            'specialization_1' => 'nullable|string|max:255',
            'specialization_2' => 'nullable|string|max:255',
            'specialization_3' => 'nullable|string|max:255',
            'framing_mode' => 'nullable|in:Titular,Suplinitor,Contractual,Pensionat',
            'decision_number' => 'nullable|string|max:255',
            'decision_date' => 'nullable|date',
            'decision_issuer' => 'nullable|string|max:255',
            'faculty' => 'nullable|string|max:255',
            'graduation_year' => 'nullable|integer|min:1950|max:2100',
            'university' => 'nullable|string|max:255',
            'last_didactic_degree' => 'nullable|string|max:255',
            'total_hours_per_week' => 'nullable|integer|min:0',
            'teaching_core_hours' => 'nullable|integer|min:0',
            'complementary_hours' => 'nullable|integer|min:0',
            'other_hours' => 'nullable|integer|min:0',
            'civil_status' => 'nullable|in:Necăsătorit,Căsătorit,Divorțat,Văduv',
            'available_for_consulting' => 'nullable|boolean',
            'is_pensioned' => 'nullable|boolean',
            'unit_with_legal_personality' => 'nullable|string|max:255',
            'locality' => 'nullable|string|max:255',
            'environment' => 'nullable|in:Urban,Rural',
            'notes' => 'nullable|string',
            'email' => 'nullable|email|max:255',
        ]);

        $data['teacher_id'] = $teacher->id;
        $data['last_updated_at'] = now()->toDateString();

        $profile = TeacherProfile::updateOrCreate(
            ['teacher_id' => $teacher->id],
            $data
        );

        return response()->json($profile, 201);
    }

    /**
     * Update teacher profile
     */
    public function update(Request $request, Teacher $teacher)
    {
        $profile = $teacher->profile;

        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found'
            ], 404);
        }

        $data = $request->validate([
            'cnp' => 'nullable|string|unique:teachers_profiles,cnp,' . $profile->id,
            'date_of_birth' => 'nullable|date',
            'birthplace' => 'nullable|string|max:255',
            'gender' => 'nullable|in:M,F',
            'father_initial' => 'nullable|string|max:1',
            'didactic_function' => 'nullable|string|max:255',
            'specialization_1' => 'nullable|string|max:255',
            'specialization_2' => 'nullable|string|max:255',
            'specialization_3' => 'nullable|string|max:255',
            'framing_mode' => 'nullable|in:Titular,Suplinitor,Contractual,Pensionat',
            'decision_number' => 'nullable|string|max:255',
            'decision_date' => 'nullable|date',
            'decision_issuer' => 'nullable|string|max:255',
            'faculty' => 'nullable|string|max:255',
            'graduation_year' => 'nullable|integer|min:1950|max:2100',
            'university' => 'nullable|string|max:255',
            'last_didactic_degree' => 'nullable|string|max:255',
            'total_hours_per_week' => 'nullable|integer|min:0',
            'teaching_core_hours' => 'nullable|integer|min:0',
            'complementary_hours' => 'nullable|integer|min:0',
            'other_hours' => 'nullable|integer|min:0',
            'civil_status' => 'nullable|in:Necăsătorit,Căsătorit,Divorțat,Văduv',
            'available_for_consulting' => 'nullable|boolean',
            'is_pensioned' => 'nullable|boolean',
            'unit_with_legal_personality' => 'nullable|string|max:255',
            'locality' => 'nullable|string|max:255',
            'environment' => 'nullable|in:Urban,Rural',
            'notes' => 'nullable|string',
            'email' => 'nullable|email|max:255',
        ]);

        $data['last_updated_at'] = now()->toDateString();

        $profile->update($data);

        return response()->json($profile);
    }

    /**
     * Delete profile (soft delete)
     */
    public function destroy(Teacher $teacher)
    {
        $profile = $teacher->profile;

        if (!$profile) {
            return response()->json([
                'message' => 'Profile not found'
            ], 404);
        }

        $profile->delete();

        return response()->json(null, 204);
    }
}
