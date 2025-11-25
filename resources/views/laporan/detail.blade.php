@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="container mt-4">

    <h3 class="fw-semibold mb-3">
        Detail Laporan — {{ $laporan->periode }}
    </h3>

    <a href="{{ route('laporan.index') }}" class="btn btn-secondary mb-4">
        ← Kembali
    </a>

    @if($transaksis->isEmpty())
        <div class="alert alert-warning">
            Tidak ada transaksi pada tanggal ini.
        </div>
    @endif

    @foreach ($transaksis as $trx)
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="fw-semibold mb-3">
                    Transaksi #{{ $trx->id_transaksi }}
                </h5>

                <p class="mb-2"><strong>Total Harga:</strong> Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</p>
                <p class="mb-3"><strong>Kasir:</strong> {{ $trx->kasir->nama ?? 'Riswan' }}</p>

                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trx->details as $detail)
                            <tr class="text-center">
                                <td>
                                    {{ $detail->nama_barang }}
                                </td>
                                <td>{{ $detail->jumlah_barang }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    @endforeach

</div>
@endsection
