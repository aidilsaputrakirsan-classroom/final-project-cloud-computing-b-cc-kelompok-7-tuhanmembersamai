<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ExplorationController;
use App\Http\Controllers\User\UserController as ProfileController;
use App\Http\Controllers\Admin\CategoryController;


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
Route::prefix('dashboard')->name('admin.')->group(function () {
    // Dashboard utama
    Route::get('/', function () {
        return view('pages.admin.dashboard');
    })->name('dashboard');

    // Manajemen User
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Post
    Route::get('/post', function () {
        return view('pages.admin.post');
    })->name('post');

    // === CRUD Categories ===
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });
});