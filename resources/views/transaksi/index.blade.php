@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Transaksi Penjualan</h2>

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
let items = [];

document.getElementById('barang').addEventListener('change', e => {
    const harga = e.target.selectedOptions[0]?.dataset.harga || 0;
    document.getElementById('harga').value = harga;
});

document.getElementById('tambah').addEventListener('click', () => {
    const select = document.getElementById('barang');
    const id_barang = select.value;
    const option = select.selectedOptions[0];
    if (!option) return alert('Pilih barang terlebih dahulu!');
    const nama = option.text.split('(')[0].trim();
    const harga = parseFloat(option.dataset.harga || 0);
    const stok = parseInt(option.dataset.stok || 0);
    const jumlah = parseInt(document.getElementById('jumlah').value || 0);

    if (!id_barang || jumlah <= 0) return alert('Isi barang dan jumlah dengan benar!');
    if (jumlah > stok) return alert('Jumlah melebihi stok!');

    const subtotal = harga * jumlah;
    items.push({ id_barang, nama, harga, jumlah, subtotal });
    renderTable();

    // reset form input barang
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
        document.getElementById('kembalian').value = kembali >= 0 ? 'Rp ' + kembali.toLocaleString('id-ID') : '-';
    };
}

function hapusItem(i) {
    items.splice(i, 1);
    renderTable();
}

document.getElementById('simpanTransaksi').addEventListener('click', async () => {
    const total = items.reduce((a,b)=>a+b.subtotal,0);
    const pembayaran = parseFloat(document.getElementById('pembayaran').value || 0);
    const kembalian = pembayaran - total;

    if (items.length === 0) return alert('Belum ada barang!');
    if (pembayaran < total) return alert('Pembayaran kurang!');

    try {
        const res = await fetch('{{ route("transaksi.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items, total_harga: total, pembayaran, kembalian })
        });
        const data = await res.json();
        alert(data.message);
        if (data.success) location.reload();
    } catch (err) {
        alert('Terjadi kesalahan saat menyimpan transaksi!');
        console.error(err);
    }
});
</script>
@endsection
