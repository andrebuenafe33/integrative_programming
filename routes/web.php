<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PusherController;

Route::get('/', function () {
    return view('welcome');
})->name('home');


// Users //
Route::get('users', [UserController::class, 'index'])->name('users');
Route::get('users/create', [UserController::class, 'create']);
Route::get('users/{id}/edit', [UserController::class, 'edit']);
Route::get('/get/users/{id}', [UserController::class, 'getUserById']);
Route::put('/update/users/{id}', [UserController::class, 'updateUser']);

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('profile', [UserController::class, 'profile'])->name('profile');

// Pusher //
Route::get('/pusher', [PusherController::class, 'index'])->name('pusher');
Route::post('/broadcast', [PusherController::class, 'broadcast']);
Route::post('/receive', [PusherController::class, 'receive']);