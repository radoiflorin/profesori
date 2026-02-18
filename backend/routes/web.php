<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\TimetableController;

Route::middleware('api')->prefix('api')->group(function () {
    Route::apiResource('teachers', TeacherController::class);
    Route::apiResource('timetables', TimetableController::class);
});
