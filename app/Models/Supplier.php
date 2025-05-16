<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // Wajib override, karena Laravel default-nya 'suppliers'
    protected $table = 'supplier';

    protected $fillable = ['nama_supplier', 'kontak', 'alamat'];

    public function transaksiPembelian()
    {
        return $this->hasMany(TransaksiPembelianBahanBaku::class, 'supplier_id');
    }
}