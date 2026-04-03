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
    Route::get('login', [AuthController::class, 'login_view'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

// Protected
Route::middleware(['auth'])->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('update');
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
