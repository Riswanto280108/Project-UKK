@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
  <h4 class="mb-3 fw-semibold">Dashboard</h4>

  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div class="card text-bg-primary">
        <div class="card-body">
          <h6 class="card-title">Total Barang</h6>
          <h3>{{ $totalBarang }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-bg-success">
        <div class="card-body">
          <h6 class="card-title">Total Kategori</h6>
          <h3>{{ $totalKategori }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-bg-warning">
        <div class="card-body">
          <h6 class="card-title">Total Kasir</h6>
          <h3>{{ $totalKasir }}</h3>
        </div>
      </div>
    </div>

    {{-- ✅ Card Pendapatan Hari Ini --}}
    <div class="col-md-3">
      <div class="card text-bg-info">
        <div class="card-body">
          <h6 class="card-title">Pendapatan Terbaru</h6>
          <h3>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        </div>
      </div>
    </div>
  </div>

  {{-- Barang Terbaru --}}
  <h5 class="mt-4 mb-2">Barang Terbaru</h5>
  <div class="table-responsive">
    <table class="table table-bordered align-middle">
      <thead class="table-light text-center">
        <tr>
          <th>No</th>
          <th>Nama Barang</th>
          <th>Kategori</th>
          <th>Stok</th>
          <th>Harga</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($barangs as $index => $barang)
        <tr>
          <td class="text-center">{{ $index + 1 }}</td>
          <td>{{ $barang->nama_barang }}</td>
          <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
          <td class="text-center">{{ $barang->stok }}</td>
          <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center text-muted">Belum ada data barang</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

 
@endsection
