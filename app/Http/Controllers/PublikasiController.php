<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PublikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() // menampilkan semua data
    {
        $publikasi = Publikasi::all();
        return response()->json(['data' => $publikasi]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id) // menampilkan satu data saja
    {
        $publikasi = Publikasi::findOrFail($id);
        return response()->json(['data' => $publikasi]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // Menambah data
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'releaseDate' => 'required|date',
                'description' => 'nullable|string',
                'coverUrl' => 'nullable|url',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        }

        $publikasi = Publikasi::create($validated);
        return response()->json($publikasi, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request) // Mengubah data (untuk PATCH atau PUT)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'releaseDate' => 'required|date',
                'description' => 'nullable|string',
                'coverUrl' => 'nullable|url',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        }

        $publikasi = Publikasi::findOrFail($id);
        $publikasi->fill($validated); // Menggunakan fill untuk semua data tervalidasi
        $publikasi->save();
        return response()->json(['data' => $publikasi], 200);
    }

    // Metode 'change' yang Anda miliki sebelumnya (jika modul menggunakannya secara spesifik)
    // Jika modul Anda punya instruksi khusus untuk 'change', ini bisa dipakai.
    // Jika tidak, metode 'update' di atas sudah cukup untuk PATCH/PUT.
    public function change($id, Request $request)
    {
        try {
            $request->validate([
                'title'=>'required',
                'releaseDate'=>'required',
                'description' => 'nullable|string',
                'coverUrl' => 'nullable|url',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        }

        $publikasi = Publikasi::findOrFail($id);
        $publikasi->fill($request->only([
            'title', 'releaseDate', 'description', 'coverUrl'
        ])); // Hapus ->save() di sini
        $publikasi->save(); // save() cukup dipanggil sekali
        return response()->json(['data'=>$publikasi], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) // Menghapus data
    {
        $publikasi = Publikasi::findOrFail($id);
        $publikasi->delete();
        return response()->json(['message' => 'Publikasi berhasil dihapus'], 204); // 204 No Content
    }
}
