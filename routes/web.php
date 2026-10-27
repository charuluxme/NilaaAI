<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/upload', [ResumeController::class, 'uploadForm'])->name('upload');
    Route::get('/resumes', [ResumeController::class, 'index'])->name('resumes.index');
    Route::get('/resumes/{resume}', [ResumeController::class, 'show'])->name('resumes.show');
    
    Route::get('/interviews', [InterviewController::class, 'index'])->name('interviews.index');
    Route::get('/interview/{resume}', [InterviewController::class, 'show'])->name('interview');
    
    Route::get('/feedback/{resume}', function ($resumeId) {
        return view('feedback', ['resumeId' => $resumeId]);
    })->name('feedback');
    
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
    Route::put('/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.update-role');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
});

require __DIR__.'/auth.php';

