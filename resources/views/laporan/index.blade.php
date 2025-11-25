@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3 fw-semibold">Laporan</h3>

    {{-- Form Filter Tanggal --}}
    <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <label class="form-label fw-semibold">Pilih Tanggal</label>
            <input type="date" name="tanggal" class="form-control"
                value="{{ request('tanggal') }}">
        </div>

        <div class="col-md-3 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary">Filter</button>

            @if(request('tanggal'))
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </div>
    </form>

    {{-- Tabel Laporan --}}
    <table class="table table-bordered align-middle">
        <thead class="table-light text-center">
            <tr>
                <th>Periode</th>
                <th>Jumlah Transaksi</th>
                <th>Total Pendapatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporans as $laporan)
                <tr class="text-center">
                    <td>{{ $laporan->periode }}</td>
                    <td>{{ $laporan->jumlah_transaksi }}</td>
                    <td>Rp {{ number_format($laporan->total_pendapatan, 0, ',', '.') }}</td>
                    <td class="text-center">
    <a href="{{ route('laporan.detail', $laporan->periode) }}" class="btn btn-info btn-sm">
        Lihat Detail
    </a>
</td>

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
