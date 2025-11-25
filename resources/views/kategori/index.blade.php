@extends('layouts.app')
@section('title', 'Kategori')
@section('content')
<div class="container mt-4">
    <h2>Data Kategori</h2>

    {{-- Notifikasi Error --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Notifikasi Success --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tombol Tambah --}}
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
        Tambah Kategori
    </button>

    {{-- Tabel --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategoris as $index => $kategori)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kategori->nama_kategori }}</td>
                <td>

                    {{-- Tombol Edit --}}
                    <button class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editKategoriModal{{ $kategori->id_kategori }}">
                        Edit
                    </button>

                    {{-- Tombol Hapus --}}
                    <form action="{{ route('kategori.destroy', $kategori->id_kategori) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                            Hapus
                        </button>
                    </form>

                    {{-- Modal Edit --}}
                    <div class="modal fade"
                         id="editKategoriModal{{ $kategori->id_kategori }}"
                         tabindex="-1"
                         aria-labelledby="editKategoriLabel{{ $kategori->id_kategori }}"
                         aria-hidden="true">

                        <div class="modal-dialog">
                            <div class="modal-content">

                                <form action="{{ route('kategori.update', $kategori->id_kategori) }}"
                                      method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Kategori</h5>
                                        <button type="button" class="btn-close"
                                                data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Nama Kategori</label>
                                            <input type="text"
                                                   name="nama_kategori"
                                                   class="form-control"
                                                   value="{{ $kategori->nama_kategori }}"
                                                   required>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal">
                                            Batal
                                        </button>
                                        <button type="submit"
                                                class="btn btn-primary">
                                            Simpan
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Modal Tambah --}}
<div class="modal fade"
     id="tambahKategoriModal"
     tabindex="-1"
     aria-labelledby="tambahKategoriLabel"
     aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    {{-- Error dalam modal --}}
                    @if ($errors->has('nama_kategori'))
                        <div class="alert alert-danger py-2">
                            {{ $errors->first('nama_kategori') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label>Nama Kategori</label>
                        <input type="text"
                               name="nama_kategori"
                               class="form-control"
                               required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- Modal otomatis terbuka jika ada error --}}
@if ($errors->has('nama_kategori'))
<script>
    new bootstrap.Modal(document.getElementById('tambahKategoriModal')).show();
</script>
@endif

@endsection

