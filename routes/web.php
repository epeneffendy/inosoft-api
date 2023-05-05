<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/motor',[\App\Http\Controllers\MotorController::class, 'index']);
Route::get('/motor/{id}',[\App\Http\Controllers\MotorController::class, 'show']);
Route::post('/motor',[\App\Http\Controllers\MotorController::class, 'store']);
Route::put('/motor/{id}',[\App\Http\Controllers\MotorController::class, 'update']);
Route::delete('/motor/{id}',[\App\Http\Controllers\MotorController::class, 'destroy']);

Route::get('/mobil',[\App\Http\Controllers\MobilController::class, 'index']);
Route::get('/mobil/{id}',[\App\Http\Controllers\MobilController::class, 'show']);
Route::post('/mobil',[\App\Http\Controllers\MobilController::class, 'store']);
Route::put('/mobil/{id}',[\App\Http\Controllers\MobilController::class, 'update']);
Route::delete('/mobil/{id}',[\App\Http\Controllers\MobilController::class, 'destroy']);

Route::get('/stok-kendaraan/{type}',[\App\Http\Controllers\StokKendaraanController::class, 'index']);

Route::post('/penjualan-kendaraan',[\App\Http\Controllers\PenjualanController::class, 'store']);
Route::get('/laporan-penjualan/{col}/{value}',[\App\Http\Controllers\PenjualanController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/token', [AuthController::class, 'token']);
Route::post('/me', [AuthController::class, 'me']);

