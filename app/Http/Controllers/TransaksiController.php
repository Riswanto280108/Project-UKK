<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;
use App\Models\Laporan;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('transaksi.index', compact('barangs'));
    }

    public function store(Request $request)
    {
        $data = $request->isJson() ? $request->json()->all() : $request->all();

        if (empty($data['items']) || !is_array($data['items'])) {
            return response()->json(['success' => false, 'message' => 'Tidak ada barang yang ditambahkan'], 422);
        }

        $total_harga = floatval($data['total_harga'] ?? 0);
        $pembayaran  = floatval($data['pembayaran'] ?? 0);
        $kembalian   = floatval($data['kembalian'] ?? 0);

        if ($pembayaran < $total_harga) {
            return response()->json(['success' => false, 'message' => 'Pembayaran kurang dari total harga'], 422);
        }

        DB::beginTransaction();
        try {
            $kasir = auth()->guard('kasir')->user();
            if (!$kasir) {
                return response()->json(['success' => false, 'message' => 'Kasir belum login'], 401);
            }

            $transaksi = Transaksi::create([
                'id_kasir' => $kasir->id_kasir,
                'tanggal_transaksi' => Carbon::now(),
                'total_harga' => $total_harga,
                'pembayaran' => $pembayaran,
                'kembalian' => $kembalian,
            ]);

            foreach ($data['items'] as $item) {
                $barang = Barang::lockForUpdate()->find($item['id_barang']);
                if (!$barang) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Barang tidak ditemukan'], 404);
                }

                if ($barang->stok < $item['jumlah']) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => "Stok {$barang->nama_barang} tidak cukup"], 422);
                }

                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_barang' => $barang->id_barang,
                    'jumlah_barang' => $item['jumlah'],
                    'subtotal' => $item['subtotal'],
                ]);

                $barang->stok -= $item['jumlah'];
                $barang->save();
            }

            // Update laporan
            $periode = Carbon::now()->toDateString();
            $laporan = Laporan::firstOrNew(['periode' => $periode]);
            $laporan->total_pendapatan = ($laporan->total_pendapatan ?? 0) + $total_harga;
            $laporan->jumlah_transaksi = ($laporan->jumlah_transaksi ?? 0) + 1;
            $laporan->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Transaksi error: ' . $e->getMessage(), ['data' => $data]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
