<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\RekapanController;
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
    Route::get('/admin/rekapan/harian', [RekapanController::class, 'harian'])->name('admin.dashboard');
    Route::resource('admin/pegawai', AccountController::class)->names('admin.pegawai');
    Route::get('/admin/shift/{id}', [RekapanController::class, 'showAbsensi'])->name('admin.absensi');
});

require __DIR__.'/auth.php';
