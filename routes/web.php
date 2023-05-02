<?php

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
Route::post('/motor',[\App\Http\Controllers\MotorController::class, 'store']);
Route::put('/motor/{id}',[\App\Http\Controllers\MotorController::class, 'update']);
Route::delete('/motor/{id}',[\App\Http\Controllers\MotorController::class, 'destroy']);
