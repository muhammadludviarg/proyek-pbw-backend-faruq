<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\AuthController;

// Rute yang tidak memerlukan autentikasi Sanctum, atau menggunakan middleware 'web'
// Untuk SPA, Sanctum membutuhkan rute /sanctum/csrf-cookie untuk diakses tanpa middleware 'api' prefix,
// dan login/logout seringkali juga diletakkan di luar middleware 'api' group atau menggunakan 'web' group
// agar cookie dan sesi berfungsi dengan baik.

Route::group(['middleware' => ['web']], function () {
    // Rute Sanctum untuk mendapatkan CSRF token
    // Ini biasanya otomatis dibuat oleh Sanctum, tetapi pastikan ia dapat diakses.
    // Tidak perlu ditambahkan secara eksplisit di sini jika Sanctum sudah mengurusnya.
    // Endpoint /sanctum/csrf-cookie tidak punya prefix /api secara default.

    Route::post('/login', [AuthController::class, 'login']); // Rute login
    Route::post('/logout', [AuthController::class, 'logout']); // Rute logout (kadang juga diletakkan di luar auth:sanctum)
});


// Rute yang memerlukan autentikasi dengan Sanctum token
Route::middleware('auth:sanctum')->group(function () {
    // Rute untuk mendapatkan data user yang sedang login
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rute untuk Publikasi
    Route::get('/publikasi', [PublikasiController::class, 'index']); // GET semua publikasi
    Route::post('/publikasi', [Publikasi::class, 'store']); // POST publikasi baru

    // Rute untuk operasi pada satu publikasi berdasarkan ID
    Route::get('/publikasi/{publikasi}', [PublikasiController::class, 'show']); // GET detail publikasi
    Route::put('/publikasi/{publikasi}', [PublikasiController::class, 'update']); // UPDATE publikasi (gunakan PUT)
    Route::patch('/publikasi/{publikasi}', [PublikasiController::class, 'update']); // PATCH publikasi (opsional, juga update)
    Route::delete('/publikasi/{publikasi}', [PublikasiController::class, 'destroy']); // DELETE publikasi

    // Rute logout juga bisa diletakkan di sini jika Anda lebih suka,
    // tetapi seringkali lebih baik di grup 'web' seperti di atas untuk SPA.
    // Jika di sini, maka logout membutuhkan token, yang biasanya ok.
    // Route::post('/logout', [AuthController::class, 'logout']);
});
