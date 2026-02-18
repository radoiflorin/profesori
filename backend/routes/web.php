<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\TimetableController;
use App\Http\Controllers\Api\TeacherProfileController;

Route::middleware('api')->prefix('api')->group(function () {
    Route::apiResource('teachers', TeacherController::class);
    Route::apiResource('timetables', TimetableController::class);

    // Teacher Profiles endpoints
    Route::post('teachers/{teacher}/profile', [TeacherProfileController::class, 'store']);
    Route::get('teachers/{teacher}/profile', [TeacherProfileController::class, 'show']);
    Route::put('teachers/{teacher}/profile', [TeacherProfileController::class, 'update']);
    Route::delete('teachers/{teacher}/profile', [TeacherProfileController::class, 'destroy']);
});
