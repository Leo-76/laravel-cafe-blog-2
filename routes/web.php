<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// -----------------------------------------------------------------------
// Public routes
// -----------------------------------------------------------------------

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/articles', [PostController::class, 'index'])->name('posts.index');
Route::get('/articles/{slug}', [PostController::class, 'show'])->name('posts.show');

// Comments (public posting, authenticated users auto-approved)
Route::post('/articles/{post}/comments', [CommentController::class, 'store'])
    ->name('comments.store');

// -----------------------------------------------------------------------
// Authenticated routes
// -----------------------------------------------------------------------

Route::middleware('auth')->group(function () {
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

    Route::patch('/comments/{comment}/approve', [CommentController::class, 'approve'])
        ->name('comments.approve');
});

// -----------------------------------------------------------------------
// Admin routes
// -----------------------------------------------------------------------

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('posts', AdminPostController::class);
});

// -----------------------------------------------------------------------
// Auth routes (provided by Laravel Breeze / custom)
// -----------------------------------------------------------------------

require __DIR__.'/auth.php';
