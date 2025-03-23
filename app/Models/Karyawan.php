<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    /** @use HasFactory<\Database\Factories\KaryawanFactory> */
    use HasFactory;
    protected $table = 'karyawan'; // Pastikan tabel sesuai dengan database
    protected $fillable = ['nama', 'jabatan', 'email', 'telepon'];
}
