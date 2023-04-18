<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CodeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Authenticated
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Users
    Route::prefix('/users')->name('users.')->group(function () {
        // My user
        Route::get('/me', [AuthController::class, 'user'])->name('me');
        // Codes by user
        Route::get('/{id}/codes', [CodeController::class, 'user'])->name('codes');

        Route::get('/', [UserController::class, 'index'])->middleware('role:M')->name('index');
        Route::get('/{id}', [UserController::class, 'show'])->middleware('role:M')->name('show');
        Route::patch('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Codes
    Route::prefix('/codes')->name('codes.')->middleware('role:M')->group(function () {
        // Users by code
        Route::get('/{id}/users', [UserController::class, 'code'])->name('users');

        Route::get('/', [CodeController::class, 'index'])->name('index');
        Route::get('/{id}', [CodeController::class, 'show'])->name('show');
        Route::post('/', [CodeController::class, 'store'])->name('store');
        Route::patch('/{id}', [CodeController::class, 'update'])->name('update');
        Route::delete('/{id}', [CodeController::class, 'destroy'])->name('destroy');
    });
});
