<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('kategori')->get(); // ✅ ambil barang beserta kategori
        $kategori = Kategori::all(); // untuk dropdown di modal tambah/edit
        return view('barang.index', compact('barang', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'id_kategori' => 'required|exists:kategoris,id_kategori',
        ]);

        Barang::create($request->all());
        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());
        return redirect()->back()->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Barang::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }
}
