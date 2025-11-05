<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->bigIncrements('id_barang');
            $table->string('nama_barang');
            $table->unsignedBigInteger('id_kategori');
            $table->integer('stok');
            $table->decimal('harga', 12, 2);
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
