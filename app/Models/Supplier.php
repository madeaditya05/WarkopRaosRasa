<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier'; // ← sudah benar

    protected $fillable = ['nama_supplier', 'kontak', 'alamat'];

    // Hapus relasi ke dirinya sendiri yang tidak perlu
    // public function supplier() { ... } ← dihapus

    // Ini relasi yang benar ke transaksi pembelian
    public function transaksiPembelian()
    {
        return $this->hasMany(TransaksiPembelianBahanBaku::class, 'supplier_id');
    }
}