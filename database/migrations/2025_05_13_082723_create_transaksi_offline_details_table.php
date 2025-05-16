<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_offline_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_offline_id')->constrained()->onDelete('cascade');
        $table->foreignId('menu_makanan_id')->constrained()->onDelete('cascade');
        $table->integer('jumlah');
        $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_offline_detail');
    }
};
