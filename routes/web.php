<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExplorationController;
use App\Http\Controllers\HomePageController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ExplorationController;
use App\Http\Controllers\User\UserController as ProfileController;
use App\Http\Controllers\Admin\CategoryController;

// Tambahan:
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CommentController;

// ========================
//      PUBLIC
// ========================
Route::get('/', [ExplorationController::class, 'index'])->name('exploration');
Route::resource('eksplorasi', ExplorationController::class)->except(['create','edit','update','destroy']);
Auth::routes();

// ========================
//      USER
// ========================
Route::middleware(['isLogin'])->group(function () {
<<<<<<< HEAD
    Route::post('eksplorasi/like/{id}', [ExplorationController::class, 'like'])->name('eksplorasi.like');
    Route::post('eksplorasi/comment/{id}', [ExplorationController::class, 'comment'])->name('eksplorasi.comment');

    Route::resource('profile', App\Http\Controllers\User\ArtworkController::class)
        ->except(['create','show','edit','update']);

    Route::get('user/edit-profile', [ProfileController::class, 'index'])->name('edit.profile');
    Route::put('user/update', [ProfileController::class, 'update'])->name('update.profile');
    Route::put('user/update-photo', [ProfileController::class, 'updateProfile'])->name('update.profile.photo');
});

// ========================
/*      ADMIN              */
// ========================
Route::prefix('dashboard')->name('admin.')->group(function () {

    Route::get('/', fn() => view('pages.admin.dashboard'))->name('dashboard');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Halaman statis lama (opsional)
    Route::get('/post', fn() => view('pages.admin.post'))->name('post');

    // ====== CRUD POSTS -> pakai tabel artworks & views: pages/admin/posts/*.blade.php
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/',                   [PostController::class, 'index'])->name('index');
        Route::get('/{artwork}',          [PostController::class, 'show'])->name('show');       // route-model binding Artwork
        Route::get('/{artwork}/edit',     [PostController::class, 'edit'])->name('edit');
        Route::put('/{artwork}',          [PostController::class, 'update'])->name('update');
        Route::delete('/{artwork}',       [PostController::class, 'destroy'])->name('destroy');
    });

    // Delete Comment
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // ====== Categories (Supabase)
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/',           [CategoryController::class, 'index'])->name('index');
        Route::get('/create',     [CategoryController::class, 'create'])->name('create');
        Route::post('/',          [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}',       [CategoryController::class, 'show'])->name('show');
        Route::get('/{id}/edit',  [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}',       [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}',    [CategoryController::class, 'destroy'])->name('destroy');
    });
=======
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
>>>>>>> feature/notification
});


// Home page routes
Route::get('/home', [App\Http\Controllers\HomePageController::class, 'index'])->name('home');
Route::post('/home/search', [App\Http\Controllers\HomePageController::class, 'search']);
