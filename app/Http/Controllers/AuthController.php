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
        // Pastikan user terautentikasi sebelum mencoba menghapus token
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logout berhasil!'], 200);
        }
        // Jika tidak ada user terautentikasi, kembalikan response 401
        return response()->json(['message' => 'User not authenticated'], 401);
    }
}
