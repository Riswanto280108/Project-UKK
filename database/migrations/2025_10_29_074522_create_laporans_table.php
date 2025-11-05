<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->bigIncrements('id_laporan');
            $table->date('periode');
            $table->decimal('total_pendapatan', 15, 2)->default(0);
            $table->integer('jumlah_transaksi')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};