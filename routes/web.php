<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;


// Redirect '/' to login if not authenticated
Route::get('/', function () {
    return redirect()->route('home');
})->middleware('auth');

// Authentication Routes
Auth::routes();

// Custom Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Home Route
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Grouped Routes that require Authentication
Route::middleware(['auth'])->group(function () {

    // Task Resource Routes
    Route::resource('tasks', TaskController::class);

    // Comments on tasks (Shallow nesting prevents deeply nested URLs)
    Route::get('/tasks/{task}/comments', [CommentController::class, 'index'])->name('tasks.comments.index');
    Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('tasks.comments.store');

    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    // Search for users via AJAX
    Route::get('/tasks/search-user', [TaskController::class, 'searchUser'])->name('tasks.searchUser');

    // Fetch logged-in user info
    Route::get('/fetch-user', [UserController::class, 'fetchUser'])->name('fetch.user');
});
