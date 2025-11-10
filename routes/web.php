<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ExplorationController;
use App\Http\Controllers\User\UserController as ProfileController;

Route::get('/', [ExplorationController::class, 'index'])->name('exploration');
Route::resource('eksplorasi', ExplorationController::class)->except(['create', 'edit', 'update', 'destroy']);

Auth::routes();

Route::middleware(['isLogin'])->group(function () {
    Route::post('eksplorasi/like/{id}', [ExplorationController::class, 'like'])->name('eksplorasi.like');
    Route::post('eksplorasi/comment/{id}', [ExplorationController::class, 'comment'])->name('eksplorasi.comment');

    Route::resource('profile', App\Http\Controllers\User\ArtworkController::class)->except(['create', 'show', 'edit', 'update']);
    Route::get('user/edit-profile', [ProfileController::class, 'index'])->name('edit.profile');
    Route::put('user/update', [ProfileController::class, 'update'])->name('update.profile');
    Route::put('user/update-photo', [ProfileController::class, 'updateProfile'])->name('update.profile.photo');
});


// === Area Admin ===
Route::prefix('dashboard')->group(function () {
    Route::get('/', function () {
        return view('pages.admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/post', function () {
        return view('pages.admin.post');
    })->name('admin.post');

    Route::get('/categories', function () {
        return view('pages.admin.categories');
    })->name('admin.categories');
});
