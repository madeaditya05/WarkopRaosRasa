<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiOffline;

class LaporanJurnalController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi offline beserta totalnya
     */
    public function index()
    {
        // Load transaksi dengan relasi details dan menu makanan di setiap detail
        $transaksis = TransaksiOffline::with('details.menuMakanan')->get();

        return view('laporan.jurnal', compact('transaksis'));
    }

    /**
     * Menampilkan detail transaksi berdasarkan ID
     */
    public function show($id)
    {
        $transaksi = TransaksiOffline::with('details.menuMakanan')->findOrFail($id);

        return view('laporan.show', compact('transaksi'));
    }
}
