<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MenuMakanan;

class TransaksiOfflineDetail extends Model
{
    // Nama tabel di database
    protected $table = 'transaksi_offline_detail';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'transaksi_offline_id',
        'menu_makanan_id',
        'jumlah',
        'subtotal'
    ];

    /**
     * Relasi ke tabel menu_makanan
     * Setiap detail transaksi berelasi dengan satu menu makanan
     */
    public function menuMakanan()
    {
        return $this->belongsTo(MenuMakanan::class, 'menu_makanan_id');
    }


    /**
     * Relasi ke transaksi offline
     * (opsional, kalau kamu mau akses parent transaksi)
     */
    public function transaksiOffline()
    {
        return $this->belongsTo(TransaksiOffline::class, 'transaksi_offline_id');
    }
}
