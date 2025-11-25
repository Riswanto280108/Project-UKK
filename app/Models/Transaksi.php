<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transaksi';
    protected $fillable = ['tanggal', 'total_harga', 'id_kasir','pembayaran','kembalian','tanggal_transaksi'];

    public function kasir()
    {
        return $this->belongsTo(Kasir::class, 'id_kasir');
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
    public function laporan()
{
    return $this->belongsTo(Laporan::class, 'periode', 'periode');
}

}
