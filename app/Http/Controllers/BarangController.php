<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('kategori')->get();
        $kategori = Kategori::all();
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

        // Cek duplikat nama barang
        if (Barang::where('nama_barang', $request->nama_barang)->exists()) {
            return redirect()->back()->with('error', 'Barang tersebut sudah ada!');
        }

        Barang::create($request->all());
        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        // Cek duplikat ketika update
        if (Barang::where('nama_barang', $request->nama_barang)
            ->where('id_barang', '!=', $id)
            ->exists()
        ) {
            return redirect()->back()->with('error', 'Nama barang sudah digunakan!');
        }

        $barang->update($request->all());
        return redirect()->back()->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Barang::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }
}
