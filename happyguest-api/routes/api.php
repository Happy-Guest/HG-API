<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReserveController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Roles: Admin > Manager > User
| Middlewares: auth:api, role, authorize
|  -> Role: If indicated role is Manager, then Admin can access.
|  -> authorize: If indicated id is not the same as authenticated user, verify if authenticated user is Manager or Admin.
|  -> Valid-Code: Verify if the user has a valid code.
*/

// Auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Authenticated
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'user'])->name('me');
    Route::get('/valid-code', [CodeController::class, 'valid_code'])->name('valid-code');
    Route::post('/change-password', [AuthController::class, 'change_Password'])->name('change-password');
    Route::post('/register-team', [AuthController::class, 'register_team'])->middleware('role:M')->name('register-team');

    // Users
    Route::prefix('/users')->name('users.')->group(function () {
        // Codes by User
        Route::prefix('/{id}/codes')->name('codes.')->group(function () {
            Route::get('/', [CodeController::class, 'user'])->middleware('authorize')->name('index');

            // Associate & Disassociate Code
            Route::post('/{code}/associate', [CodeController::class, 'associate'])->middleware('authorize')->name('associate');
            Route::delete('/{code}/disassociate', [CodeController::class, 'disassociate'])->middleware('authorize')->name('disassociate');
        });

        // Complaints by User
        Route::prefix('/{id}/complaints')->name('complaints.')->group(function () {
            Route::get('/', [ComplaintController::class, 'user'])->middleware('authorize')->name('index');
        });

        // Reviews by User
        Route::prefix('/{id}/reviews')->name('reviews.')->group(function () {
            Route::get('/', [ReviewController::class, 'user'])->middleware('authorize')->name('index');
        });

        // Checkouts by User
        Route::prefix('/{id}/checkouts')->name('checkouts.')->group(function () {
            Route::get('/', [CheckoutController::class, 'user'])->middleware('authorize')->name('index');
        });

        Route::get('/', [UserController::class, 'index'])->middleware('role:M')->name('index');
        Route::get('/blocked', [UserController::class, 'show_blocked'])->middleware('role:M')->name('blocked');
        Route::get('/unblocked', [UserController::class, 'show_unblocked'])->middleware('role:M')->name('unblocked');
        Route::get('/{id}', [UserController::class, 'show'])->middleware('role:M')->name('show');
        Route::get('/role/{role}', [UserController::class, 'show_role'])->middleware('role:M')->name('role');
        Route::post('/{id}', [UserController::class, 'update'])->middleware('authorize')->name('update');
        Route::patch('/{id}/block', [UserController::class, 'block'])->middleware('authorize')->name('block');
        Route::patch('/{id}/unblock', [UserController::class, 'unblock'])->middleware('authorize')->name('unblock');
        Route::delete('/{id}', [UserController::class, 'destroy'])->middleware('authorize')->name('destroy');
    });

    // Codes (Only Managers & Admins)
    Route::prefix('/codes')->name('codes.')->middleware('role:M')->group(function () {
        // Users by Code
        Route::get('/{id}/users', [UserController::class, 'code'])->name('users');

        Route::get('/', [CodeController::class, 'index'])->name('index');
        Route::get('/{id}', [CodeController::class, 'show'])->name('show');
        Route::post('/', [CodeController::class, 'store'])->name('store');
        Route::patch('/{id}', [CodeController::class, 'update'])->name('update');
        Route::delete('/{id}', [CodeController::class, 'destroy'])->name('destroy');
    });

    // Complaints
    Route::prefix('/complaints')->name('complaints.')->group(function () {
        // File by Complaint
        Route::get('/{id}/file/{file}', [ComplaintController::class, 'file'])->name('file');

        Route::get('/', [ComplaintController::class, 'index'])->middleware('role:M')->name('index');
        Route::get('/{id}', [ComplaintController::class, 'show'])->name('show');
        Route::post('/', [ComplaintController::class, 'store'])->middleware('valid-code')->name('store');
        Route::patch('/{id}', [ComplaintController::class, 'update'])->middleware('role:M')->name('update');
        Route::delete('/{id}', [ComplaintController::class, 'destroy'])->middleware('role:M')->name('destroy');
    });

    // Reviews
    Route::prefix('/reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->middleware('role:M')->name('index');
        Route::get('/{id}', [ReviewController::class, 'show'])->name('show');
        Route::post('/', [ReviewController::class, 'store'])->middleware(['valid-code'])->name('store');
        Route::delete('/{id}', [ReviewController::class, 'destroy'])->middleware('role:M')->name('destroy');
    });

    //Items
    Route::prefix('/items')->name('items.')->group(function () {
        Route::get('/', [ItemController::class, 'index'])->middleware('role:M')->name('index');
        Route::get('/{id}', [ItemController::class, 'show'])->middleware('role:M')->name('show');
        Route::post('/', [ItemController::class, 'store'])->middleware('role:M')->name('store');
        Route::patch('/{id}', [ItemController::class, 'update'])->middleware('role:M')->name('update');
        Route::delete('/{id}', [ItemController::class, 'destroy'])->middleware('role:M')->name('destroy');

        // Associate & Disassociate to Service
        Route::post('/{id}/service/{service}/associate', [ItemController::class, 'associate'])->middleware('role:M')->name('associate');
        Route::delete('/{id}/item/{service}/disassociate', [ItemController::class, 'disassociate'])->middleware('role:M')->name('disassociate');
    });

    //Services
    Route::prefix('/services')->name('services.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->middleware('role:M')->name('index');
        Route::get('/{id}', [ServiceController::class, 'show'])->name('show');
        Route::get('/{id}/items', [ItemController::class, 'service'])->name('items');
        Route::post('/', [ServiceController::class, 'store'])->middleware('role:A')->name('store');
        Route::patch('/{id}', [ServiceController::class, 'update'])->middleware('role:M')->name('update');
        Route::delete('/{id}', [ServiceController::class, 'destroy'])->middleware('role:A')->name('destroy');
    });

    //Orders
    Route::prefix('/orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->middleware('role:M')->name('index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
        Route::post('/', [OrderController::class, 'store'])->middleware('valid-code')->name('store');
        Route::patch('/{id}', [OrderController::class, 'update'])->middleware('role:M')->name('update');
        Route::delete('/{id}', [OrderController::class, 'destroy'])->middleware('role:M')->name('destroy');
    });

    //Reserves
    Route::prefix('/reserves')->name('reserves.')->group(function () {
        Route::get('/', [ReserveController::class, 'index'])->middleware('role:M')->name('index');
        Route::get('/{id}', [ReserveController::class, 'show'])->name('show');
        Route::post('/', [ReserveController::class, 'store'])->middleware('valid-code')->name('store');
        Route::patch('/{id}', [ReserveController::class, 'update'])->middleware('role:M')->name('update');
        Route::delete('/{id}', [ReserveController::class, 'destroy'])->middleware('role:M')->name('destroy');
    });

    // Checkouts
    Route::prefix('/checkouts')->name('checkouts.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->middleware('role:M')->name('index');
        Route::get('/{id}', [CheckoutController::class, 'show'])->name('show');
        Route::post('/', [CheckoutController::class, 'store'])->middleware('valid-code')->name('store');
        Route::patch('/{id}/validate', [CheckoutController::class, 'updateValidate'])->middleware('role:M')->name('updateValidate');
        Route::delete('/{id}', [CheckoutController::class, 'destroy'])->middleware('role:M')->name('destroy');
    });

    // Statistics
    Route::prefix('/stats')->name('stats.')->group(function () {
        Route::get('/home', [StatisticController::class, 'index'])->middleware('role:M')->name('home');
        Route::get('/graph', [StatisticController::class, 'graph'])->middleware('role:M')->name('graph');
    });
});
