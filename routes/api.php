<?php

use App\Http\Controllers\Api\InterviewController;
use App\Http\Controllers\Api\ResumeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Use web middleware for session-based authentication
Route::middleware(['web', 'auth'])->group(function () {
    // Resume endpoints
    Route::post('/upload-resume', [ResumeController::class, 'upload']);
    Route::get('/resume/{resume}/analysis', [ResumeController::class, 'analysis']);
    
    // Interview endpoints
    Route::post('/interview/{resume}/start', [InterviewController::class, 'start']);
    Route::post('/interview/{session}/answer', [InterviewController::class, 'answer']);
    Route::get('/interview/{session}/status', [InterviewController::class, 'status']);
});

