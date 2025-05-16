<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi_pembelian_bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('supplier')->onDelete('cascade');
            $table->date('tanggal');
            // Hapus kolom status dan tambahkan subtotal
            $table->decimal('subtotal', 15, 2)->default(0); // menampung nilai subtotal, bisa sesuaikan presisi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_pembelian_bahan_baku');
    }
};
