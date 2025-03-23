<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;

    protected $table = 'supplier'; // Sesuaikan dengan nama tabel di database

    protected $fillable = ['nama_supplier', 'kontak', 'alamat'];

    
}
