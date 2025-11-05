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
        $request->validate(['nama_kategori' => 'required|string|max:100']);
        Kategori::create(['nama_kategori' => $request->nama_kategori]);
        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate(['nama_kategori' => 'required|string|max:100']);
        $kategori->update(['nama_kategori' => $request->nama_kategori]);
        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
