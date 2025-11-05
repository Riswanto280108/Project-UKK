<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Kasir extends Authenticatable
{
    use Notifiable;

    protected $table = 'kasirs';
    protected $primaryKey = 'id_kasir'; // 👈 WAJIB ADA
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_kasir',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_kasir', 'id_kasir');
    }
}







