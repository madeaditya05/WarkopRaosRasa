<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gaji';
    
    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'gaji_pokok',
        'tunjangan',
        'total_gaji',
        'status'
    ];

    /**
     * Relasi ke model Karyawan
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}