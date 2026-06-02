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
    Route::patch('/avatar', [AvatarController::class, 'update'])->name('avatar.update');
    // Session routes
    Route::get('/sessions/create', [SessionController::class, 'create'])->name('sessions.create');
    Route::get('/sessions/choose-modules', [SessionController::class, 'chooseModules'])->name('sessions.choose-modules');
    Route::post('/sessions/join', [SessionController::class, 'join'])->name('sessions.join');
    Route::post('/sessions', [SessionController::class, 'store'])->name('sessions.store');
    Route::get('/sessions/{session}', [SessionController::class, 'show'])->name('sessions.show');
});

require __DIR__.'/auth.php';
