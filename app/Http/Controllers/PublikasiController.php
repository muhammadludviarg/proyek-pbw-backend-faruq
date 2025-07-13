<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers; 
 
use App\Models\Publikasi; 
use Illuminate\Http\Request; 
 
class PublikasiController extends Controller 
{ 
    public function index() //menampilkan semua data
    { 
        $publikasi = Publikasi::all(); 
        return response()->json(['data'=> $publikasi]); 
    } 
    public function show($id) //menampilkan satu data saja 
    { 
        $publikasi = Publikasi::findOrFail($id); 
        return response()->json(['data'=>$publikasi]); 
    } 

    //Menambah data
    public function store(Request $request) 
    { 
        $validated = $request->validate([ 
            'title' => 'required|string|max:255', 
            'releaseDate' => 'required|date', 
            'description' => 'nullable|string', 
            'coverUrl' => 'nullable|url', 
        ]); 
 
        $publikasi = Publikasi::create($validated); 
        return response()->json($publikasi, 201); 
    } 

    // Mengubah data 
    public function update($id, Request $request)
    {
        $request->validate([
            'title'=>'required'
        ]); 

        $publikasi = Publikasi::findOrFail($id); 
        $publikasi->title = $request->title; 
        $publikasi->save(); 
        return response()->json(['data'=>$publikasi]);
    }

    public function change($id, Request $request)
    {
        $request->validate([
            'title'=>'required',
            'releaseDate'=>'required',
            'description' => 'nullable|string', 
            'coverUrl' => 'nullable|url', 
        ]); 

        $publikasi = Publikasi::findOrFail($id); 
        $publikasi->fill($request->only([
            'title', 'releaseDate', 'description', 'coverUrl'
        ]))->save();
        $publikasi->save(); 
        return response()->json(['data'=>$publikasi]);
    }

    // Menghapus data
    public function destroy($id)
    {
        $publikasi = Publikasi::findOrFail($id); 
        $publikasi->delete(); 
        return response()->json(['data'=>$publikasi]); 
    }

}