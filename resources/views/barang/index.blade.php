@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Data Barang</h2>

    {{-- Tombol Tambah --}}
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">
        Tambah Barang
    </button>

    {{-- Tabel Barang --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barang as $index => $b)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $b->nama_barang }}</td>
                <td>{{ $b->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $b->stok }}</td>
                <td>Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                <td>
                    {{-- Tombol Edit --}}
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                        data-bs-target="#editBarangModal{{ $b->id_barang }}">Edit</button>

                    {{-- Tombol Hapus --}}
                    <form action="{{ route('barang.destroy', $b->id_barang) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</button>
                    </form>
                </td>
            </tr>

            {{-- Modal Edit Barang --}}
            <div class="modal fade" id="editBarangModal{{ $b->id_barang }}" tabindex="-1"
                aria-labelledby="editBarangLabel{{ $b->id_barang }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('barang.update', $b->id_barang) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editBarangLabel{{ $b->id_barang }}">Edit Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Nama Barang</label>
                                    <input type="text" name="nama_barang" class="form-control"
                                        value="{{ $b->nama_barang }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Kategori</label>
                                    <select name="id_kategori" class="form-select" required>
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id_kategori }}"
                                                {{ $b->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                                                {{ $k->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Stok</label>
                                    <input type="number" name="stok" class="form-control" value="{{ $b->stok }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Harga</label>
                                    <input type="number" name="harga" class="form-control" value="{{ $b->harga }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada data barang.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal Tambah Barang --}}
<div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-labelledby="tambahBarangLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahBarangLabel">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="id_kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori as $k)
                            <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
