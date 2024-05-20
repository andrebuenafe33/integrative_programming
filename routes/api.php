<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', [UserController::class, 'login']);

// Route::middleware('auth:api')->group(function(){ 
   
Route::post('/register', [UserController::class, 'createUser']);

Route::get('/users/{id}/edit', [UserController::class, 'editUser']);

Route::get('/users/{id}', [UserController::class, 'updateUser']);

Route::get('/userList', [UserController::class, 'list']);
// });