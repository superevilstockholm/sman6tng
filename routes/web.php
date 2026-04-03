<?php

use Illuminate\Support\Facades\Route;

// Auth Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ChangePasswordController;

// Profile Controller
use App\Http\Controllers\ProfileController;

// Account Controllers
use App\Http\Controllers\Account\UserController;

Route::get('/', function () {
    return view('pages.index');
});

Route::middleware(['guest'])->group(function () {
    // Auth
    Route::prefix('login')->controller(LoginController::class)->name('login.')->group(function () {
        Route::get('/', 'view')->name('view');
        Route::post('/', 'attempt')->name('attempt');
    });
});

// Protected
Route::middleware(['auth'])->group(function () {
    // Auth
    Route::post('logout', [LogoutController::class, 'attempt'])->name('logout.attempt');
    Route::prefix('change-password')->controller(ChangePasswordController::class)->name('change-password.')->group(function () {
        Route::get('/', 'view')->name('view');
        Route::put('/', 'attempt')->name('attempt');
    });
    // Profile
    Route::prefix('profile')->controller(ProfileController::class)->name('profile.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/edit', 'edit')->name('edit');
        Route::put('/update', 'update')->name('update');
    });
    // Dashboard
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
            Route::get('/', function () {
                return 'Hello admin';
            })->name('index');
            Route::prefix('account')->name('account.')->group(function () {
                Route::resource('users', UserController::class)->parameters([
                    'users' => 'user',
                ]);
            });
        });
        Route::middleware(['role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
            Route::get('/', function () {
                return 'Hello teacher';
            })->name('index');
        });
        Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
            Route::get('/', function () {
                return 'Helo student';
            })->name('index');
        });
    });
});
