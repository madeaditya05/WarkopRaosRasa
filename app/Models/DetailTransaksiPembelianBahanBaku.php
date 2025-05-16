<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiPembelianBahanBaku extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi_pembelian_bahan_baku';

    protected $fillable = [
        'transaksi_id',
        'bahan_baku_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    // Relasi ke Transaksi
    public function transaksi()
    {
        return $this->belongsTo(TransaksiPembelianBahanBaku::class, 'transaksi_id');
    }

    // Relasi ke Bahan Baku
    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }
}
