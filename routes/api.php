<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\AuthController; 

Route::post('/login', [AuthController::class, 'login']);
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

Route::middleware('auth:sanctum')->group(function () { //Bisa digunkan jika sudah login
    // Publikasi
    Route::get('/publikasi', [PublikasiController::class, 'index']);
    Route::post('/publikasi', [PublikasiController::class, 'store']);
    Route::get('/publikasi/{id}', [PublikasiController::class, 'show']);
    Route::patch('/publikasi/{id}', [PublikasiController::class, 'update']);
    Route::put('/publikasi/{id}', [PublikasiController::class, 'change']);
    Route::delete('/publikasi/{id}', [PublikasiController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});