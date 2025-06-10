<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TransaksiOfflineDetail;
use App\Models\Pelanggan;

class TransaksiOffline extends Model
{
    protected $table = 'transaksi_offline';
    protected $fillable = ['no_faktur', 'pelanggan_id', 'tanggal_pesan', 'total_harga'];

    /**
     * Relasi: satu transaksi offline punya banyak detail transaksi
     */
    public function details()
    {
        return $this->hasMany(TransaksiOfflineDetail::class, 'transaksi_offline_id');
    }

    /**
     * Relasi: transaksi dimiliki oleh satu pelanggan
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }
}
