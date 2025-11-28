<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MeController;

Route::middleware(['web', 'auth:sanctum'])->group(function () {
    Route::get('/user', MeController::class);
});
