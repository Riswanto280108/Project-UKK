@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

  <h3 class="fw-semibold mb-4">Dashboard</h3>

  {{-- === Stat Cards === --}}
  <div class="row g-3 mb-4">

    <div class="col-12 col-sm-6 col-md-3">
      <div class="card text-bg-primary h-100">
        <div class="card-body">
          <h6 class="card-title">Total Barang</h6>
          <h3 class="mb-0">{{ $totalBarang }}</h3>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="card text-bg-success h-100">
        <div class="card-body">
          <h6 class="card-title">Total Kategori</h6>
          <h3 class="mb-0">{{ $totalKategori }}</h3>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="card text-bg-info h-100">
        <div class="card-body">
          <h6 class="card-title">Total Kasir</h6>
          <h3 class="mb-0">{{ $totalKasir }}</h3>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="card text-bg-warning h-100">
        <div class="card-body">
          <h6 class="card-title">Pendapatan Terbaru</h6>
          <h3 class="mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        </div>
      </div>
    </div>

  </div>

  {{-- === Barang Terbaru Table === --}}
  <h5 class="mt-3 mb-3">Barang Terbaru</h5>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
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
          <td colspan="5" class="text-center text-muted py-3">
            Belum ada data barang
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>
@endsection
