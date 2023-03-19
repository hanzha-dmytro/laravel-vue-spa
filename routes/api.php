<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
    Route::post('/auth/logout', [LoginController::class, 'logout'])->name('auth.logout');

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'info']);
        Route::put('/', [ProfileController::class, 'update']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->can('users:read')->name('users.index');
        Route::post('/', [UserController::class, 'store'])->can('users:create')->name('users.store');
        Route::get('/all', [UserController::class, 'all'])->can('users:read')->name('users.all');
        Route::get('/{user}', [UserController::class, 'show'])->can('users:read')->name('users.show');
        Route::put('/{user}', [UserController::class, 'update'])->can('users:update')->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->can('users:delete')->name('users.destroy');
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->can('roles:read')->name('roles.index');
        Route::post('/', [RoleController::class, 'store'])->can('roles:create')->name('roles.store');
        Route::get('/all', [RoleController::class, 'all'])->can('roles:read')->name('roles.all');
        Route::get('/{role}', [RoleController::class, 'show'])->can('roles:read')->name('roles.show');
        Route::put('/{role}', [RoleController::class, 'update'])->can('roles:update')->name('roles.update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->can('roles:delete')->name('roles.destroy');
    });

    Route::get('permissions', [PermissionController::class, 'all'])->can('permissions:read')->name('permissions.all');

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->can('categories:read')->name('categories.index');
        Route::post('/', [CategoryController::class, 'store'])->can('categories:create')->name('categories.store');
        Route::get('/all', [CategoryController::class, 'all'])->can('categories:read')->name('categories.all');
        Route::get('/{category}', [CategoryController::class, 'show'])->can('categories:read')->name('categories.show');
        Route::put('/{category}', [CategoryController::class, 'update'])->can('categories:update')->name('categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->can('categories:delete')->name('categories.destroy');
    });

    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index'])->can('posts:read')->name('posts.index');
        Route::post('/', [PostController::class, 'store'])->can('posts:create')->name('posts.store');
        Route::get('/all', [PostController::class, 'all'])->can('posts:read')->name('posts.all');
        Route::get('/{post}', [PostController::class, 'show'])->can('posts:read')->name('posts.show');
        Route::put('/{post}', [PostController::class, 'update'])->can('posts:update')->name('posts.update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->can('posts:delete')->name('posts.destroy');
    });

    Route::prefix('comments')->group(function () {
        Route::get('/', [CommentController::class, 'index'])->can('comments:read')->name('comments.index');
        Route::post('/', [CommentController::class, 'store'])->can('comments:create')->name('comments.store');
        Route::get('/all', [CommentController::class, 'all'])->can('comments:read')->name('comments.all');
        Route::get('/{comment}', [CommentController::class, 'show'])->can('comments:read')->name('comments.show');
        Route::put('/{comment}', [CommentController::class, 'update'])->can('comments:update')->name('comments.update');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->can('comments:delete')->name('comments.destroy');
        Route::put('/{comment}/status', [CommentController::class, 'changeStatus'])->can('comments:update')->name('comments.change-status');
    });
});
