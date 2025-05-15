<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index'])->name('home');
Route::get('post', [PostController::class, 'index'])->name('posts.index');
Route::get('post/{post}', [PostController::class, 'show'])->name('posts.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::prefix('posts')->group(function () {
        Route::get('create', [PostController::class, 'create'])->name('posts.create');
        Route::post('store', [PostController::class, 'store'])->name('posts.store');
        Route::get('edit/{post}', [PostController::class, 'edit'])->name('posts.edit');
        Route::post('update/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('destroy/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    });
});

require __DIR__.'/auth.php';
