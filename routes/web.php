<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/', HomeController::class)->name('home');

    Route::get('/users/{user}/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/users/{user}/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/users/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('posts', PostController::class)->except(['index', 'create']);
    Route::resource('posts.comments', CommentController::class)->except(['index', 'create', 'show'])->scoped();

    Route::get('/search', SearchController::class)->name('search');

    Route::resource('likes', LikeController::class)->only(['store', 'destroy']);

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/latest', [NotificationController::class, 'latest'])->name('notifications.latest');
    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
});
