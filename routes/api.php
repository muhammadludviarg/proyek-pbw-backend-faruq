// routes/api.php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\AuthController;

// Rute Login (tanpa middleware auth:sanctum)
Route::post('/login', [AuthController::class, 'login']);

// Rute yang memerlukan autentikasi dengan Sanctum token
Route::middleware('auth:sanctum')->group(function () {
    // Rute Logout (di dalam grup auth:sanctum)
    Route::post('/logout', [AuthController::class, 'logout']); // Ini seharusnya sudah cukup
    
    // Rute untuk mendapatkan data user yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rute untuk Publikasi
    Route::get('/publikasi', [PublikasiController::class, 'index']);
    Route::post('/publikasi', [PublikasiController::class, 'store']);
    Route::get('/publikasi/{id}', [PublikasiController::class, 'show']);
    Route::patch('/publikasi/{id}', [PublikasiController::class, 'update']);
    Route::put('/publikasi/{id}', [PublikasiController::class, 'change']); // Sesuai kode Anda sebelumnya
    Route::delete('/publikasi/{id}', [PublikasiController::class, 'destroy']);
});
