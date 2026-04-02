<?php

use Illuminate\Support\Facades\Route;

// Account Controllers
use App\Http\Controllers\Account\UserController;

// Protected
Route::middleware(['auth'])->group(function () {
    Route::prefix('account')->name('account.')->group(function () {
        Route::resource('users', UserController::class)->parameters([
            'users' => 'user',
        ]);
    });
});
