<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExplorationController;

Route::get('/', [App\Http\Controllers\ExplorationController::class, 'index'])->name('exploration');
Route::resource('eksplorasi', App\Http\Controllers\ExplorationController::class)->except('create', 'edit', 'update', 'destroy');

Auth::routes();

Route::middleware(['isLogin'])->group(function () {
    Route::post('eksplorasi/like/{id}', [App\Http\Controllers\ExplorationController::class, 'like'])->name('eksplorasi.like');
    Route::post('eksplorasi/comment/{id}', [App\Http\Controllers\ExplorationController::class, 'comment'])->name('eksplorasi.comment');
    Route::post('/exploration/{id}/like', [\App\Http\Controllers\ExplorationController::class, 'like'])->name('exploration.like');
    Route::post('/exploration/{id}/comment', [\App\Http\Controllers\ExplorationController::class, 'comment'])->name('exploration.comment');

    Route::resource('profile', App\Http\Controllers\User\ArtworkController::class)->except('create', 'show', 'edit', 'update');
    Route::get('user/edit-profile', [App\Http\Controllers\User\UserController::class, 'index'])->name('edit.profile');
    Route::put('user/update', [App\Http\Controllers\User\UserController::class, 'update'])->name('update.profile');
    Route::put('user/update-photo', [App\Http\Controllers\User\UserController::class, 'updateProfile'])->name('update.profile.photo');
    Route::get('notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/exploration/{id}', [\App\Http\Controllers\ExplorationController::class, 'show'])->name('exploration.show');
    Route::get('/notifications', [ExplorationController::class, 'notifications'])->name('notifications.index');
});
