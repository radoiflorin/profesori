<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TimetableController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Teachers
Route::resource('teachers', TeacherController::class);
Route::post('/teachers/{teacher}/profile', [TeacherController::class, 'saveProfile'])->name('teachers.save-profile');
Route::get('/teachers/{teacher}/profile-edit', [TeacherController::class, 'editProfile'])->name('teachers.edit-profile');

// Timetables
Route::resource('timetables', TimetableController::class);
Route::get('/timetables/teacher/{teacher}', [TimetableController::class, 'byTeacher'])->name('timetables.by-teacher');
