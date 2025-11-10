<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// === Halaman Utama ===
Route::get('/', [App\Http\Controllers\ExplorationController::class, 'index'])->name('exploration');
Route::resource('eksplorasi', App\Http\Controllers\ExplorationController::class)
    ->except(['create', 'edit', 'update', 'destroy']);

Auth::routes();

// === Area User (butuh login) ===
Route::middleware(['isLogin'])->group(function () {
    Route::post('eksplorasi/like/{id}', [App\Http\Controllers\ExplorationController::class, 'like'])->name('eksplorasi.like');
    Route::post('eksplorasi/comment/{id}', [App\Http\Controllers\ExplorationController::class, 'comment'])->name('eksplorasi.comment');

    Route::resource('profile', App\Http\Controllers\User\ArtworkController::class)->except(['create', 'show', 'edit', 'update']);
    Route::get('user/edit-profile', [App\Http\Controllers\User\UserController::class, 'index'])->name('edit.profile');
    Route::put('user/update', [App\Http\Controllers\User\UserController::class, 'update'])->name('update.profile');
    Route::put('user/update-photo', [App\Http\Controllers\User\UserController::class, 'updateProfile'])->name('update.profile.photo');
});

// === Area Admin ===
Route::prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('pages.admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/users', function () {
        return view('pages.admin.users');
    })->name('admin.users');

    Route::get('/post', function () {
        return view('pages.admin.post');
    })->name('admin.post');

    Route::get('/categories', function () {
        return view('pages.admin.categories');
    })->name('admin.categories');
});

