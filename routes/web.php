<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\RekapanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\AbsensiController;
use App\Http\Controllers\User\ReimburseController;
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
    Route::get('/user/reimbursement', [ReimburseController::class, 'index'])->name('reimburse.user.index');
    Route::get('/user/reimbursement/create', [ReimburseController::class, 'create'])->name('reimburse.user.create');
    Route::post('/user/reimbursement/bensin', [ReimburseController::class, 'bensin'])->name('reimburse.user.bensin');
    Route::post('/user/reimbursement/makan', [ReimburseController::class, 'makan'])->name('reimburse.user.makan');
    Route::post('/user/reimbursement/barang', [ReimburseController::class, 'barang'])->name('reimburse.user.barang');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/rekapan/harian', [RekapanController::class, 'harian'])->name('admin.dashboard');
    Route::resource('admin/pegawai', AccountController::class)->names('admin.pegawai');
    Route::get('/admin/shift/{id}', [RekapanController::class, 'showAbsensi'])->name('admin.absensi');
    Route::get('admin/reimburse', [\App\Http\Controllers\Admin\ReimburseController::class, 'index'])->name('admin.reimburse.index');
    Route::get('admin/reimburse/pending/{id}', [\App\Http\Controllers\Admin\ReimburseController::class, 'pegawaiPending'])->name('admin.reimburse.pending');
    Route::get('admin/reimburse/lunas/{id}', [\App\Http\Controllers\Admin\ReimburseController::class, 'pegawaiLunas'])->name('admin.reimburse.lunas');
    Route::get('admin/reimburse/total/{id}', [\App\Http\Controllers\Admin\ReimburseController::class, 'pegawaiTotal'])->name('admin.reimburse.total');
    Route::get('admin/reimburse/bensin/{id}', [\App\Http\Controllers\Admin\ReimburseController::class, 'bensin'])->name('admin.reimburse.bensin');
    Route::put('admin/reimburse/bensin/{id}', [\App\Http\Controllers\Admin\ReimburseController::class, 'bensinLunas']);
    Route::get('admin/reimburse/makan/{id}', [\App\Http\Controllers\Admin\ReimburseController::class, 'makan'])->name('admin.reimburse.makan');
    Route::put('admin/reimburse/makan/{id}', [\App\Http\Controllers\Admin\ReimburseController::class, 'makanLunas']);
    Route::get('admin/reimburse/barang/{id}', [\App\Http\Controllers\Admin\ReimburseController::class, 'barang'])->name('admin.reimburse.barang');
    Route::put('admin/reimburse/barang/{id}', [\App\Http\Controllers\Admin\ReimburseController::class, 'barangLunas']);
});

require __DIR__.'/auth.php';
