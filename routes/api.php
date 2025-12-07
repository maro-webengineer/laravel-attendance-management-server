<?php

use App\Http\Controllers\Api\Attendance\AttendanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MeController;

Route::middleware(['web', 'auth:sanctum'])->group(function () {
    Route::get('/user', MeController::class);
});

Route::prefix('attendances')->group(function () {
    Route::middleware(['web'])->post('/login-and-clock-in', [AttendanceController::class, 'loginAndClockIn']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/clock_in', [AttendanceController::class, 'clockIn']);
        Route::patch('/clock_out', [AttendanceController::class, 'clockOut']);
    });
});
