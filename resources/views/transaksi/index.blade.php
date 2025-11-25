@extends('layouts.app')
@section('title', 'Transaksi')
@section('content')
<div class="container mt-4">
    <h2>Transaksi</h2>

    <!-- Notifikasi -->
    <div id="notifikasi" class="alert d-none position-fixed top-0 end-0 m-3 shadow" style="z-index: 9999;"></div>

    <div class="row mt-3">
        <div class="col-md-4">
            <label>Pilih Barang</label>
            <select id="barang" class="form-select">
                <option value="">-- Pilih Barang --</option>
                @foreach ($barangs as $b)
                <option value="{{ $b->id_barang }}" data-harga="{{ $b->harga }}" data-stok="{{ $b->stok }}">
                    {{ $b->nama_barang }} (Stok: {{ $b->stok }})
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>Jumlah</label>
            <input type="number" id="jumlah" class="form-control" min="1">
        </div>
        <div class="col-md-3">
            <label>Harga Satuan</label>
            <input type="text" id="harga" class="form-control" readonly>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button id="tambah" class="btn btn-success w-100">Tambahkan</button>
        </div>
    </div>

    <table class="table table-bordered mt-4" id="tabelTransaksi">
        <thead>
            <tr class="text-center">
                <th>Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total</th>
                <th id="totalHarga">Rp 0</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <div class="row mt-3">
        <div class="col-md-4 offset-md-8">
            <label>Pembayaran</label>
            <input type="number" id="pembayaran" class="form-control">
            <label class="mt-2">Kembalian</label>
            <input type="text" id="kembalian" class="form-control" readonly>
        </div>
    </div>

    <button id="simpanTransaksi" class="btn btn-primary mt-4 float-end">Simpan Transaksi</button>
</div>

<script>
// 🔔 FUNGSI NOTIFIKASI
function showNotif(pesan, tipe = 'success') {
    const notif = document.getElementById('notifikasi');
    notif.className = `alert alert-${tipe} show position-fixed top-0 end-0 m-3`;
    notif.textContent = pesan;
    notif.classList.remove('d-none');

    setTimeout(() => {
        notif.classList.add('d-none');
    }, 2500);
}

// ==================== SCRIPT TRANSAKSI ====================

let items = [];

document.getElementById('barang').addEventListener('change', e => {
    const harga = e.target.selectedOptions[0]?.dataset.harga || 0;
    document.getElementById('harga').value = harga;
});

document.getElementById('tambah').addEventListener('click', () => {
    const select = document.getElementById('barang');
    const id_barang = select.value;
    const option = select.selectedOptions[0];
    if (!option) return showNotif('Pilih barang terlebih dahulu!', 'danger');

    const nama = option.text.split('(')[0].trim();
    const harga = parseFloat(option.dataset.harga || 0);
    const stok = parseInt(option.dataset.stok || 0);
    const jumlah = parseInt(document.getElementById('jumlah').value || 0);

    if (!id_barang || jumlah <= 0) return showNotif('Isi barang dan jumlah dengan benar!', 'danger');
    if (jumlah > stok) return showNotif('Jumlah melebihi stok yang tersedia!', 'danger');

    const subtotal = harga * jumlah;
    items.push({ id_barang, nama, harga, jumlah, subtotal });

    showNotif('Barang berhasil ditambahkan!', 'success');
    renderTable();

    select.value = '';
    document.getElementById('jumlah').value = '';
    document.getElementById('harga').value = '';
});

function renderTable() {
    const tbody = document.querySelector('#tabelTransaksi tbody');
    tbody.innerHTML = '';
    let total = 0;

    items.forEach((item, index) => {
        total += item.subtotal;
        tbody.innerHTML += `
            <tr class="text-center">
                <td>${item.nama}</td>
                <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
                <td>${item.jumlah}</td>
                <td>Rp ${item.subtotal.toLocaleString('id-ID')}</td>
                <td><button class="btn btn-danger btn-sm" onclick="hapusItem(${index})">X</button></td>
            </tr>`;
    });

    document.getElementById('totalHarga').innerText = 'Rp ' + total.toLocaleString('id-ID');

    document.getElementById('pembayaran').oninput = function() {
        const bayar = parseFloat(this.value || 0);
        const kembali = bayar - total;
        document.getElementById('kembalian').value = kembali >= 0 ?
            'Rp ' + kembali.toLocaleString('id-ID') : '-';
    };
}

function hapusItem(i) {
    items.splice(i, 1);
    renderTable();
    showNotif('Barang telah dihapus!', 'warning');
}

document.getElementById('simpanTransaksi').addEventListener('click', async () => {
    const total = items.reduce((a,b)=>a+b.subtotal,0);
    const pembayaran = parseFloat(document.getElementById('pembayaran').value || 0);

    if (items.length === 0) return showNotif('Belum ada barang!', 'danger');
    if (pembayaran < total) return showNotif('Pembayaran kurang!', 'danger');

    try {
        const res = await fetch('{{ route("transaksi.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                items,
                total_harga: total,
                pembayaran,
                kembalian: pembayaran - total
            })
        });

        const data = await res.json();
        showNotif(data.message, data.success ? 'success' : 'danger');

        if (data.success) setTimeout(() => location.reload(), 1500);
    } catch (err) {
        showNotif('Terjadi kesalahan saat menyimpan transaksi!', 'danger');
        console.error(err);
    }
});
</script>
@endsection

