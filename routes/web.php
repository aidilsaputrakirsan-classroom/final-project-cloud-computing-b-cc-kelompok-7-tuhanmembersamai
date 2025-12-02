<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExplorationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\UserController as ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ActivityLogController;

// ========================
//        PUBLIC
// ========================
Route::get('/', [ExplorationController::class, 'index'])->name('exploration');

Route::resource('eksplorasi', ExplorationController::class)
    ->except(['create', 'edit', 'update', 'destroy']);

Route::post('/eksplorasi/search', [ExplorationController::class, 'search'])->name('eksplorasi.search');

Auth::routes();

// ========================
//          USER
// ========================
Route::middleware(['isLogin'])->group(function () {

    // Likes & Comments
    Route::post('eksplorasi/like/{id}', [ExplorationController::class, 'like'])->name('eksplorasi.like');
    Route::post('eksplorasi/comment/{id}', [ExplorationController::class, 'comment'])->name('eksplorasi.comment');

    Route::post('/exploration/{id}/like', [ExplorationController::class, 'like'])->name('exploration.like');
    Route::post('/exploration/{id}/comment', [ExplorationController::class, 'comment'])->name('exploration.comment');

    // User Artworks
    Route::resource('profile', App\Http\Controllers\User\ArtworkController::class)
        ->except(['create', 'show', 'edit', 'update']);

    // User Profile Update
    Route::get('user/edit-profile', [ProfileController::class, 'index'])->name('edit.profile');
    Route::put('user/update', [ProfileController::class, 'update'])->name('update.profile');
    Route::put('user/update-photo', [ProfileController::class, 'updateProfile'])->name('update.profile.photo');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');

    // Exploration show
    Route::get('/exploration/{id}', [ExplorationController::class, 'show'])->name('exploration.show');
});

// ========================
//          ADMIN
// ========================
Route::prefix('dashboard')->name('admin.')->middleware(['auth', 'is.admin'])->group(function () {

    // Dashboard Home
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // LOGOUT ADMIN
    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])
        ->name('logout');

    // USERS
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // POSTS
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/{artwork}', [PostController::class, 'show'])->name('show');
        Route::get('/{artwork}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{artwork}', [PostController::class, 'update'])->name('update');
        Route::delete('/{artwork}', [PostController::class, 'destroy'])->name('destroy');
    });

    // COMMENTS
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // CATEGORIES
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // ACTIVITY LOGS
    Route::prefix('activity-logs')->name('activity-logs.')->group(function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('index');
        Route::get('/{activityLog}', [ActivityLogController::class, 'show'])->name('show');
    });
});
