<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publikasi;
use Illuminate\Support\Facades\Storage; // Diimpor tapi tidak digunakan dalam kode ini
use Illuminate\Validation\ValidationException;

class PublikasiController extends Controller
{
    // Method untuk menampilkan semua publikasi
    public function index()
    {
        $publikasi = Publikasi::all();
        return response()->json($publikasi, 200); // Mengembalikan array publikasi langsung dengan status 200 OK
    }

    // Method untuk menyimpan publikasi baru
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'releaseDate' => 'required|date',
                'description' => 'nullable|string',
                'coverUrl' => 'nullable|url',
            ]);

            $publikasi = Publikasi::create($validated);
            return response()->json($publikasi, 201); // Mengembalikan data publikasi yang baru dibuat dengan status 201 Created
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal saat menyimpan publikasi.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Tangani error umum lainnya
            return response()->json([
                'message' => 'Terjadi kesalahan server saat menyimpan publikasi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Method untuk menampilkan detil publikasi
    public function show(Publikasi $publikasi)
    {
        return response()->json($publikasi, 200); // Mengembalikan objek publikasi langsung dengan status 200 OK
    }

    // Method untuk mengupdate publikasi (digunakan untuk PATCH)
    public function update(Request $request, Publikasi $publikasi)
    {
        try {
            // 'sometimes' berarti field tidak harus ada, tapi jika ada, harus valid
            $validatedData = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'releaseDate' => 'sometimes|required|date',
                'description' => 'sometimes|string|nullable',
                'coverUrl' => 'nullable|url',
            ]);

            $publikasi->update($validatedData); // Menggunakan update dengan array data tervalidasi

            return response()->json($publikasi, 200); // Mengembalikan data publikasi yang diperbarui dengan status 200 OK

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Gagal memperbarui data: Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan server saat memperbarui publikasi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Method 'change' yang Anda miliki (digunakan untuk PUT)
    // Ini dipertahankan terpisah dari 'update' sesuai rute Anda.
    public function change($id, Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'releaseDate' => 'required|date',
                'description' => 'nullable|string',
                'coverUrl' => 'nullable|url',
            ]);

            $publikasi = Publikasi::findOrFail($id);
            $publikasi->fill($validated);
            $publikasi->save();
            return response()->json($publikasi, 200); // Mengembalikan data publikasi langsung dengan status 200 OK
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal saat mengubah publikasi.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan server saat mengubah publikasi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Method untuk menghapus publikasi
    public function destroy($id)
    {
        try {
            $publikasi = Publikasi::findOrFail($id);
            $publikasi->delete();
            return response()->json(['message' => 'Publikasi berhasil dihapus'], 204); // 204 No Content dengan pesan
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan server saat menghapus publikasi.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
