@extends('layouts.app')

@section('title', 'Laporan Harian')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3 fw-semibold">Laporan Harian</h3>

    <table class="table table-bordered align-middle">
        <thead class="table-light text-center">
            <tr>
                <th>Periode</th>
                <th>Jumlah Transaksi</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporans as $laporan)
                <tr class="text-center">
                    <td>{{ $laporan->periode }}</td>
                    <td>{{ $laporan->jumlah_transaksi }}</td>
                    <td>Rp {{ number_format($laporan->total_pendapatan, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Belum ada data laporan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
