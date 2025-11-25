<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::query();

        // Jika ada filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('periode', $request->tanggal);
        }

        $laporans = $query->orderBy('periode', 'desc')->get();

        return view('laporan.index', compact('laporans'));
    }
  public function detail($periode)
{
    // Ambil laporan berdasarkan periode (bukan id)
    $laporan = Laporan::where('periode', $periode)->firstOrFail();

    // Ambil semua transaksi pada hari tersebut
    $transaksis = Transaksi::with([
        'details' => function($q) {
            ; // jika detail punya softdelete
        },
        'details.barang' => function($q) {
            ; // supaya barang yang sudah dihapus tetap muncul
        }
    ])
    ->whereDate('tanggal_transaksi', $periode)
    ->get();

    return view('laporan.detail', compact('laporan', 'transaksis'));
}
}

