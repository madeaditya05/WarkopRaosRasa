<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BahanBaku extends Model
{
    use HasFactory;

    protected $table = 'bahan_baku';

    protected $fillable = [
        'kode_bahan',
        'nama_bahan',
        'jumlah',
        'satuan',
        'harga_per_satuan',
        // 'subtotal' => DB::raw('jumlah * harga_per_satuan'),
    ];

    // Fungsi untuk mendapatkan kode bahan baku baru
    public static function getKodeBahanBaku()
    {
        // Ambil kode bahan terakhir
        $sql = "SELECT IFNULL(MAX(kode_bahan), 'DD-000') as kode_bahan 
                FROM bahan_baku";
        $kodebahan = DB::select($sql);
        
        // cacah hasilnya
        foreach ($kodebahan as $kdbhn) {
            $kd = $kdbhn->kode_bahan;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($kd,-3);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        
        //menyambung dengan string PR-001
        $noakhir = 'DD-'.str_pad($noakhir,3,"0",STR_PAD_LEFT); 

        return $noakhir;
    }
}