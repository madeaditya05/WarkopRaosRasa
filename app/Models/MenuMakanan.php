<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuMakanan extends Model
{
    /** @use HasFactory<\Database\Factories\MenuMakananFactory> */
    use HasFactory;

    protected $table = 'menu_makanan';

    protected $fillable = ['nama_menu', 'deskripsi', 'harga', 'stok', 'kategori','foto'];
}
