<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Carbon\Carbon;
use App\Models\Transaksi;
use App\Models\Kasir;
use App\Models\Laporan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalKategori = Kategori::count();
        $totalKasir = Kasir::count();

        // Ambil total pendapatan dari laporan terbaru
        $laporanTerbaru = Laporan::orderBy('periode', 'desc')->first();
        
        $today = Carbon::today();
        $totalPendapatan = Transaksi::whereDate('tanggal_transaksi', $today)
    ->sum('total_harga');

        // Ambil data laporan terakhir 5 hari (untuk riwayat transaksi)
        $riwayatLaporan = Laporan::orderBy('periode', 'desc')->take(5)->get();

        // Barang terbaru
        $barangs = Barang::with('kategori')->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalBarang',
            'totalKategori',
            'totalKasir',
            'totalPendapatan',
            'riwayatLaporan',
            'barangs'
        ));
    }
}
