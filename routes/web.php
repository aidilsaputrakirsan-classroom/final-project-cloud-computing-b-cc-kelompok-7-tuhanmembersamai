<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ExplorationController;
use App\Http\Controllers\User\UserController as ProfileController;
use App\Http\Controllers\Admin\CategoryController;

// ==== Tambahan untuk Post Management ====
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CommentController;


// ========================
//      PUBLIC AREA
// ========================
Route::get('/', [ExplorationController::class, 'index'])->name('exploration');
Route::resource('eksplorasi', ExplorationController::class)->except(['create', 'edit', 'update', 'destroy']);

Auth::routes();


// ========================
//      USER AREA
// ========================
Route::middleware(['isLogin'])->group(function () {

    // Like / Comment eksplorasi
    Route::post('eksplorasi/like/{id}', [ExplorationController::class, 'like'])->name('eksplorasi.like');
    Route::post('eksplorasi/comment/{id}', [ExplorationController::class, 'comment'])->name('eksplorasi.comment');

    // Artwork milik user
    Route::resource('profile', App\Http\Controllers\User\ArtworkController::class)
        ->except(['create', 'show', 'edit', 'update']);

    // Profile user
    Route::get('user/edit-profile', [ProfileController::class, 'index'])->name('edit.profile');
    Route::put('user/update', [ProfileController::class, 'update'])->name('update.profile');
    Route::put('user/update-photo', [ProfileController::class, 'updateProfile'])->name('update.profile.photo');
});


// ========================
//      ADMIN AREA
// ========================
Route::prefix('dashboard')->name('admin.')->group(function () {

    // Dashboard utama
    Route::get('/', function () {
        return view('pages.admin.dashboard');
    })->name('dashboard');

    // -----------------------
    //   Manajemen User
    // -----------------------
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // -----------------------
    //   Halaman Post (static)
    // -----------------------
    Route::get('/post', function () {
        return view('pages.admin.post');
    })->name('post');


    // ============================================
    // ✅ CRUD POSTS (artworks table)
    // ============================================
    Route::get('/posts',                [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post}',         [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit',    [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}',         [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}',      [PostController::class, 'destroy'])->name('posts.destroy');


    // ============================================
    // ✅ DELETE COMMENT
    // ============================================
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


    // ============================================
    // ✅ CRUD Categories (SUPABASE)
    // ============================================
    Route::prefix('categories')->name('categories.')->group(function () {

        Route::get('/',           [CategoryController::class, 'index'])->name('index');
        Route::get('/create',     [CategoryController::class, 'create'])->name('create');
        Route::post('/',          [CategoryController::class, 'store'])->name('store');

        Route::get('/{id}',       [CategoryController::class, 'show'])->name('show');
        Route::get('/{id}/edit',  [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}',       [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}',    [CategoryController::class, 'destroy'])->name('destroy');
    });

});
