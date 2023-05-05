<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CodeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Authenticated
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'user'])->name('me');
    Route::post('/change-password', [AuthController::class, 'change_Password'])->name('change-password');

    // Users
    Route::prefix('/users')->name('users.')->group(function () {
        // Codes by User
        Route::prefix('/{id}/codes')->name('codes.')->group(function () {
            Route::get('/', [CodeController::class, 'user'])->middleware('autorize')->name('index');

            // Associate & Disassociate Code
            Route::post('/{code}/associate', [CodeController::class, 'associate'])->middleware('autorize')->name('associate');
            Route::delete('/{code}/disassociate', [CodeController::class, 'disassociate'])->middleware('autorize')->name('disassociate');
        });

        Route::get('/', [UserController::class, 'index'])->middleware('role:M')->name('index');
        Route::get('/blocked', [UserController::class, 'show_blocked'])->middleware('role:M')->name('blocked');
        Route::get('/unblocked', [UserController::class, 'show_unblocked'])->middleware('role:M')->name('unblocked');
        Route::get('/{id}', [UserController::class, 'show'])->middleware('role:M')->name('show');
        Route::get('/role/{role}', [UserController::class, 'show_role'])->middleware('role:M')->name('role');
        Route::patch('/{id}', [UserController::class, 'update'])->middleware('autorize')->name('update');
        Route::patch('/{id}/block', [UserController::class, 'block'])->middleware('role:A')->name('block');
        Route::patch('/{id}/unblock', [UserController::class, 'unblock'])->middleware('role:A')->name('unblock');	
        Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('autorize')->name('destroy');
    });

    // Codes (Only Managers)
    Route::prefix('/codes')->name('codes.')->middleware('role:M')->group(function () {
        // Users by Code
        Route::get('/{id}/users', [UserController::class, 'code'])->name('users');

        Route::get('/', [CodeController::class, 'index'])->name('index');
        Route::get('/{id}', [CodeController::class, 'show'])->name('show');
        Route::post('/', [CodeController::class, 'store'])->name('store');
        Route::patch('/{id}', [CodeController::class, 'update'])->name('update');
        Route::delete('/{id}', [CodeController::class, 'destroy'])->name('destroy');
    });
});
