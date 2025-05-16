<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiOffline extends Model
{

    protected $table = 'transaksi_offline';

    protected $fillable = ['no_faktur', 'pelanggan_id', 'tanggal_pesan', 'total_harga'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function details()
    {
        return $this->hasMany(TransaksiOfflineDetail::class);
    }
}
