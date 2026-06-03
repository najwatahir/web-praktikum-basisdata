<?php

use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;

// peserta
Route::get('/', [ParticipantController::class, 'index'])->name('home');
Route::post('/join', [ParticipantController::class, 'join'])->name('participant.join');
Route::post('/participant/logout', [ParticipantController::class, 'logout'])->name('participant.logout');
Route::get('/soal', [ParticipantController::class, 'questions'])->name('questions.index');
Route::get('/soal/{id}', [ParticipantController::class, 'solve'])->name('questions.solve');
Route::post('/test', [SubmissionController::class, 'test'])->name('test');
Route::post('/submit', [SubmissionController::class, 'submit'])->name('submit');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

// admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('questions', QuestionController::class);
    Route::get('submissions', [DashboardController::class, 'submissions'])->name('submissions');
    Route::get('rekap', [DashboardController::class, 'rekap'])->name('rekap');
    Route::prefix('admin')->name('admin.')->group(function () {
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index'); 
    
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

    Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');
});
});

require __DIR__.'/auth.php';