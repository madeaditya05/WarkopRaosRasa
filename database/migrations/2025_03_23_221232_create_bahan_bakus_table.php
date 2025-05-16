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
    Schema::create('bahan_baku', function (Blueprint $table) {
        $table->id();
        $table->string('kode_bahan', 10)->unique();
        $table->string('nama_bahan', 100);
        $table->decimal('jumlah', 10, 2)->unsigned(); // FIXED
        $table->string('satuan', 20);
        $table->decimal('harga_per_satuan', 15, 2)->unsigned();
        $table->decimal('subtotal', 20, 2)->virtualAs('jumlah * harga_per_satuan'); // VIRTUAL
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_baku');
    }
};
