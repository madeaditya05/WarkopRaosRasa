<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    /** @use HasFactory<\Database\Factories\PelangganFactory> */
    use HasFactory;
    protected $table = 'pelanggan'; // Sesuaikan dengan nama tabel di database

    protected $fillable = ['nama', 'telepon', 'alamat'];
}
