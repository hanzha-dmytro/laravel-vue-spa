<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Http\Request;
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

// AUTH ROUTES
Route::middleware('guest')->prefix('auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'send'])->name('auth.forgot-password');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('auth.reset-password');
});

// PUBLIC ROUTES

// PROTECTED ROUTES
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('auth')->group(function () {
        Route::get('/logout', [LoginController::class, 'logout'])->name('auth.logout');
    });
});
