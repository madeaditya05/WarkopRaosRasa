<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPembelianBahanBaku;
use Illuminate\Http\Request;

class DetailTransaksiPembelianBahanBakuController extends Controller
{
    public function show($id)
    {
        $transaksi = TransaksiPembelianBahanBaku::with('details.bahanBaku')->findOrFail($id);
        return view('transaksi.detail', compact('transaksi'));
    }
}
