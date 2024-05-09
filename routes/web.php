<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('users', [UserController::class, 'index'])->name('users');

Route::get('register', [RegisterController::class, 'register'])->name('register');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
