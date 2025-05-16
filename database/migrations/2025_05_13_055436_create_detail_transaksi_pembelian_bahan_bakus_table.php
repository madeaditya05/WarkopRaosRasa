<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksi_pembelian_bahan_baku', function (Blueprint $table) {
            $table->id();
            
            // Harus eksplisit karena nama kolom != nama tabel acuan
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('bahan_baku_id');

            $table->integer('jumlah');
            $table->decimal('harga_satuan', 15, 2); // harga per item
            $table->decimal('subtotal', 15, 2); // subtotal (optional kalau kamu simpan juga)

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('transaksi_id')->references('id')->on('transaksi_pembelian_bahan_baku')->onDelete('cascade');
            $table->foreign('bahan_baku_id')->references('id')->on('bahan_baku')->onDelete('cascade');

            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi_pembelian_bahan_baku');
    }
};
