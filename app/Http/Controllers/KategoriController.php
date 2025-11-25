<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('kategori.index', compact('kategoris'));
    }

   public function store(Request $request)
{
    $request->validate([
        'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori'
    ], [
        'nama_kategori.unique' => 'Kategori sudah ada dan tidak bisa ditambahkan lagi!'
    ]);

    Kategori::create(['nama_kategori' => $request->nama_kategori]);

    return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
}


   public function update(Request $request, Kategori $kategori)
{
    $request->validate([
        'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori,' . $kategori->id_kategori . ',id_kategori'
    ], [
        'nama_kategori.unique' => 'Kategori sudah ada dan tidak bisa digunakan!'
    ]);

    $kategori->update(['nama_kategori' => $request->nama_kategori]);

    return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
}


    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
