// app/Http/Controllers/AuthController.php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // ... (kode login)
    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); // Dapatkan user yang sedang login
        if ($user) {
            // Menghapus token saat ini atau semua token user
            // Modul Anda hanya menggunakan currentAccessToken()->delete();
            $request->user()->currentAccessToken()->delete(); 
            // Atau untuk menghapus semua token: $user->tokens()->delete();
        }

        return response()->json(['message' => 'Logout berhasil!'], 200); // Pastikan status 200 OK
    }
}
