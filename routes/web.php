<?php

use Illuminate\Support\Facades\Route;

// Auth Controller
use App\Http\Controllers\AuthController;

// Account Controllers
use App\Http\Controllers\Account\UserController;

Route::middleware(['guest'])->group(function () {
    // Auth
    Route::get('login', [AuthController::class, 'login_view'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

// Protected
Route::middleware(['auth'])->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
            Route::get('/', function () {
                return '';
            })->name('index');
            Route::prefix('account')->name('account.')->group(function () {
                Route::resource('users', UserController::class)->parameters([
                    'users' => 'user',
                ]);
            });
        });
        Route::middleware(['role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
            Route::get('/', function () {
                return '';
            })->name('index');
        });
        Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
            Route::get('/', function () {
                return '';
            })->name('index');
        });
    });
});
