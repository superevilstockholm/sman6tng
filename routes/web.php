<?php

use Illuminate\Support\Facades\Route;

// Account Controllers
use App\Http\Controllers\Account\UserController;

// Protected
Route::middleware(['auth'])->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
            Route::get('/', function () {
                return '';
            })->name('index');
            Route::prefix('account')->name('account.')->group(function () {
                Route::resource('users', UserController::class)->parameters([
                    'users' => 'user',
                ]);
            });
        });
        Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
            Route::get('/', function () {
                return '';
            })->name('index');
        });
        Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
            Route::get('/', function () {
                return '';
            })->name('index');
        });
    });
});
