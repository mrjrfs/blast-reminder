<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ParticipantImportController;

// Auth Routes
Route::get('', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login-process');
// Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
// Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('events', EventController::class);
    Route::resource('events.participants', ParticipantController::class)->shallow();
    Route::resource('reminders', ReminderController::class)->shallow();

    Route::get('/events/{event}/participants/import', [ParticipantImportController::class, 'create'])->name('participants.import.create');
    Route::post('/events/{event}/participants/import', [ParticipantImportController::class, 'store'])->name('participants.import.store');
    Route::get('/events/{event}/participants/import-history', [ParticipantImportController::class, 'history'])->name('participants.import.history');
    Route::get('/import/{import}', [ParticipantImportController::class, 'show'])->name('participants.import.show');
});
