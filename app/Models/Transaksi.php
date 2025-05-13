<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{

    protected $table = 'transaksi';

    protected $fillable = [
        'order_id',
        'user_id',
        'status',
        'total',
        'keranjang_data',
    ];
}
