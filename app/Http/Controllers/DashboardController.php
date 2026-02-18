<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Timetable;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTeachers = Teacher::count();
        $totalTimetables = Timetable::count();
        $uniqueSubjects = Teacher::distinct()->count('subject');

        // Get timetables grouped by day
        $timetablesByDay = Timetable::selectRaw('day, COUNT(*) as count')
            ->groupBy('day')
            ->get()
            ->keyBy('day');

        // Get subjects distribution
        $subjectDistribution = Teacher::selectRaw('subject, COUNT(*) as count')
            ->groupBy('subject')
            ->get();

        // Get role distribution
        $roleDistribution = Teacher::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->get();

        // Recent teachers
        $recentTeachers = Teacher::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalTeachers',
            'totalTimetables',
            'uniqueSubjects',
            'timetablesByDay',
            'subjectDistribution',
            'roleDistribution',
            'recentTeachers'
        ));
    }
}
