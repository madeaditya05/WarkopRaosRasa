<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPembelianBahanBaku extends Model
{
    protected $table = 'transaksi_pembelian_bahan_baku';
    protected $fillable = ['supplier_id', 'tanggal', 'subtotal'];

    public const STATUS_BELUM_DIBAYAR = 'belum dibayar';
    public const STATUS_SUDAH_DIBAYAR = 'sudah dibayar';

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // Gunakan plural untuk relasi hasMany
    public function details()
    {
        // 'transaksi_id' adalah foreign key di table detail pembelian yang mengacu ke transaksi
        return $this->hasMany(DetailTransaksiPembelianBahanBaku::class, 'transaksi_id');
    }
}