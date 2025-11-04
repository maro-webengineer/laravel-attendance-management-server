<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MeController;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('/me', MeController::class);
});
