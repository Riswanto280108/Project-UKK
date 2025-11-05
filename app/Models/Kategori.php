<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $primaryKey = 'id_kategori'; // ✅ wajib sesuai migrasi
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_kategori',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_kategori', 'id_kategori');
    }
}
