<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\AuthController;

// Rute yang menggunakan middleware 'web' untuk session/CSRF (Login dan Logout)
// Ini adalah praktik yang lebih kuat untuk SPA dengan Sanctum
Route::group(['middleware' => ['web']], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']); // Logout di sini
});

// Rute yang memerlukan autentikasi dengan Sanctum token
Route::middleware('auth:sanctum')->group(function () {
    // Rute untuk mendapatkan data user yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rute untuk Publikasi
    Route::get('/publikasi', [PublikasiController::class, 'index']);
    Route::post('/publikasi', [PublikasiController::class, 'store']);
    Route::get('/publikasi/{id}', [PublikasiController::class, 'show']);
    Route::patch('/publikasi/{id}', [PublikasiController::class, 'update']); // Menggunakan PATCH untuk update
    Route::put('/publikasi/{id}', [PublikasiController::class, 'change']); // Sesuai kode Anda, jika 'change' berbeda dari 'update'
    Route::delete('/publikasi/{id}', [PublikasiController::class, 'destroy']);
});
