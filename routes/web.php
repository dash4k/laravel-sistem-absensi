<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\AbsensiController;
use App\Http\Controllers\User\ShiftController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
    Route::resource('absensi', AbsensiController::class);
    Route::resource('shift', ShiftController::class);
    Route::get('/shift-recap', [ShiftController::class, 'shiftList'])->name('shift.list');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.rekapan-harian');
    })->name('admin.dashboard');
    // Add other admin routes here
});

require __DIR__.'/auth.php';
