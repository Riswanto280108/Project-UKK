<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';
    protected $primaryKey = 'id_barang';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_barang',
        'harga',
        'stok',
        'id_kategori',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }



    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_barang');
    }
}
