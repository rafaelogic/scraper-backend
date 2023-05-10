<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AuthUserController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

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

include __DIR__.'/api/api_v1.php';

Route::post('/sanctum/token', TokenController::class);
Route::get('/users/auth', AuthUserController::class)
    ->name('user.profile');
Route::get('/login', [AuthController::class, 'login'])
    ->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('auth.logout');
