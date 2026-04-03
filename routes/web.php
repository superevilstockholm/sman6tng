<?php

use Illuminate\Support\Facades\Route;

// Auth Controller
use App\Http\Controllers\AuthController;

// Profile Controller
use App\Http\Controllers\ProfileController;

// Account Controllers
use App\Http\Controllers\Account\UserController;

Route::middleware(['guest'])->group(function () {
    // Auth
    Route::prefix('login')->name('login.')->group(function () {
        Route::get('/', [AuthController::class, 'login_view'])->name('view');
        Route::post('/', [AuthController::class, 'login'])->name('attempt');
    });
});

// Protected
Route::middleware(['auth'])->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('password')->name('password.')->group(function () {
        Route::get('/edit', [AuthController::class, 'edit_password'])->name('edit');
        Route::patch('/update', [AuthController::class, 'update_password'])->name('update');
    });
    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
    });
    // Dashboard
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
