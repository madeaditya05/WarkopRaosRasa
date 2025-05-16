<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiOfflineDetail extends Model
{

     protected $table = 'transaksi_offline_detail';

    protected $fillable = ['transaksi_offline_id', 'menu_makanan_id', 'tanggal_pesan', 'jumlah', 'subtotal'];

    public function transaksiOffline()
    {
        return $this->belongsTo(TransaksiOffline::class);
    }

    public function menuMakanan()
    {
        return $this->belongsTo(MenuMakanan::class);
    }
}
