<?php

use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Avatar routes
    Route::get('/avatar', [AvatarController::class, 'edit'])->name('avatar.edit');
    Route::post("/avatar/preview", [AvatarController::class, "preview"])->name("avatar.preview");
    Route::patch('/avatar', [AvatarController::class, 'update'])->name('avatar.update');
    // Session routes
    Route::get('/sessions/create', [SessionController::class, 'create'])->name('sessions.create');
    Route::get('/sessions/choose-modules', [SessionController::class, 'chooseModules'])->name('sessions.choose-modules');
    Route::post('/sessions/join', [SessionController::class, 'join'])->name('sessions.join');
    Route::post('/sessions', [SessionController::class, 'store'])->name('sessions.store');
    Route::get('/sessions/{session}', [SessionController::class, 'show'])->name('sessions.show');

    // Game Flow Routes
    Route::post('/sessions/{session}/start', [SessionController::class, 'start'])->name('sessions.start');
    Route::post('/sessions/{session}/answer', [SessionController::class, 'answer'])->name('sessions.answer');
    Route::post('/sessions/{session}/results', [SessionController::class, 'showResults'])->name('sessions.results');
    Route::post('/sessions/{session}/next', [SessionController::class, 'next'])->name('sessions.next');

    // Ministry routes
    Route::get('/ministries', [App\Http\Controllers\MinistryController::class, 'index'])->name('ministries.index');
    Route::post('/ministries', [App\Http\Controllers\MinistryController::class, 'store'])->name('ministries.store');
    Route::put('/ministries/{ministry}', [App\Http\Controllers\MinistryController::class, 'update'])->name('ministries.update');
    Route::delete('/ministries/{ministry}', [App\Http\Controllers\MinistryController::class, 'destroy'])->name('ministries.destroy');
    Route::post('/ministries/{ministry}/assign', [App\Http\Controllers\MinistryController::class, 'assignUser'])->name('ministries.assign');
    Route::delete('/ministries/{ministry}/user/{user}', [App\Http\Controllers\MinistryController::class, 'removeUser'])->name('ministries.remove-user');
});

// Settings routes
Route::middleware('auth')->group(function () {
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::patch('/settings/profile', [App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::post('/settings/family/join', [App\Http\Controllers\SettingsController::class, 'joinFamily'])->name('settings.family.join');
    Route::delete('/settings/family/leave', [App\Http\Controllers\SettingsController::class, 'leaveFamily'])->name('settings.family.leave');
    Route::post('/settings/session/join', [App\Http\Controllers\SettingsController::class, 'joinSession'])->name('settings.session.join');
});

require __DIR__.'/auth.php';
