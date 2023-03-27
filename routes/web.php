<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HangHoaController;
use App\Http\Controllers\LoaiHangController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\PhieuNhapController;
use App\Http\Controllers\PhieuXuatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('hang-hoa')->group(function () {
        Route::get('/', [HangHoaController::class, 'index'])->name('hang-hoa.index');
        Route::get('/xem/{code}', [HangHoaController::class, 'show'])->name('hang-hoa.show');
        Route::get('/xem/{code}?{ma_ncc}', [HangHoaController::class, 'show'])->name('hang-hoa.showInfo');
        Route::get('/them', [HangHoaController::class, 'create'])->name('hang-hoa.create');
        Route::post('/them', [HangHoaController::class, 'store'])->name('hang-hoa.store');
        Route::get('/sua/{code}', [HangHoaController::class, 'edit'])->name('hang-hoa.edit');
        Route::put('/sua/{code}', [HangHoaController::class, 'update'])->name('hang-hoa.update');
        Route::get('/sua-chi-tiet/{code}?{id}', [HangHoaController::class, 'editItem'])->name('hang-hoa.editItem');
        Route::put('/sua-chi-tiet/{code}?{id}', [HangHoaController::class, 'storeItem'])->name('hang-hoa.storeItem');
        Route::delete('/xoa/{id}', [HangHoaController::class, 'destroy'])->name('hang-hoa.delete');
    });

    Route::prefix('loai-hang')->group(function () {
        Route::get('/', [LoaiHangController::class, 'index'])->name('loai-hang.index');
        Route::get('/them', [LoaiHangController::class, 'create'])->name('loai-hang.create');
        Route::post('/them', [LoaiHangController::class, 'store'])->name('loai-hang.store');
        Route::get('/sua/{id}', [LoaiHangController::class, 'edit'])->name('loai-hang.edit');
        Route::put('/sua/{id}', [LoaiHangController::class, 'update'])->name('loai-hang.update');
        Route::get('/xem/{id}', [LoaiHangController::class, 'show'])->name('loai-hang.show');
        Route::delete('/xoa/{id}', [LoaiHangController::class, 'destroy'])->name('loai-hang.delete');
    });

    Route::prefix('nhap-kho')->group(function () {
        Route::get('/', [PhieuNhapController::class, 'index'])->name('nhap-kho.index');
        Route::get('/tao-phieu', [PhieuNhapController::class, 'create'])->name('nhap-kho.create');
        Route::post('/tao-phieu', [PhieuNhapController::class, 'store'])->name('nhap-kho.store');
        Route::post('/tao-phieu', [PhieuNhapController::class, 'import'])->name('nhap-kho.import');
        Route::get('/xem/{code}', [PhieuNhapController::class, 'show'])->name('nhap-kho.show');
    });

    Route::prefix('xuat-kho')->group(function () {
        Route::get('/', [PhieuXuatController::class, 'index'])->name('xuat-kho.index');
        Route::get('/tao-phieu', [PhieuXuatController::class, 'create'])->name('xuat-kho.create');
        Route::post('/tao-phieu', [PhieuXuatController::class, 'store'])->name('xuat-kho.store');
        Route::post('/tao-phieu-excel', [PhieuXuatController::class, 'export'])->name('xuat-kho.export');
        Route::get('/download-excel', [PhieuXuatController::class, 'download'])->name('xuat-kho.download');
        Route::get('/xem/{code}', [PhieuXuatController::class, 'show'])->name('xuat-kho.show');
    });

    Route::prefix('nha-cung-cap')->group(function () {
        Route::get('/', [NhaCungCapController::class, 'index'])->name('nha-cung-cap.index');
        Route::get('/them', [NhaCungCapController::class, 'create'])->name('nha-cung-cap.create');
        Route::post('/them', [NhaCungCapController::class, 'store'])->name('nha-cung-cap.store');
        Route::get('/xem/{code}', [NhaCungCapController::class, 'show'])->name('nha-cung-cap.show');
        Route::get('/sua/{code}', [NhaCungCapController::class, 'edit'])->name('nha-cung-cap.edit');
        Route::put('/sua/{code}', [NhaCungCapController::class, 'update'])->name('nha-cung-cap.update');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [UserController::class, 'show'])->name('user.show');
        Route::post('/doi-mat-khau', [UserController::class, 'updatePassword'])->name('user.updatePassword');
        Route::post('/doi-thong-tin', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Auth::routes();
