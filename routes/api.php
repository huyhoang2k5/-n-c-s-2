<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PhieuNhapController;
use App\Http\Controllers\Api\PhieuXuatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/nhap-kho/tao-phieu/store', [PhieuXuatController::class, 'store'])->name('api.xuat-kho.store');
Route::post('/nhap-kho/tao-phieu/export', [PhieuXuatController::class, 'export'])->name('api.xuat-kho.export');
Route::get('/xuat-kho/tao-phieu', [PhieuXuatController::class, 'search'])->name('api.xuat-kho.search');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
