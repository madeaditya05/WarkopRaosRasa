<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPembelianBahanBaku;
use Illuminate\Http\Request;

class TransaksiPembelianBahanBakuController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi pembelian bahan baku,
     * lengkap dengan supplier dan detail bahan baku yang dibeli.
     */
    public function index()
    {
        // Eager load supplier dan detail beserta bahan bakunya supaya efisien
        $transaksis = TransaksiPembelianBahanBaku::with(['supplier', 'details.bahanBaku'])->get();
        return view('transaksipembelianbahanbaku.index', compact('transaksis'));
    }

    /**
     * Mengubah status transaksi menjadi sudah dibayar (lunas).
     * 
     * @param int $id ID transaksi yang dibayar
     */
    public function bayar($id)
    {
        $transaksi = TransaksiPembelianBahanBaku::findOrFail($id);
        $transaksi->subtotal = TransaksiPembelianBahanBaku::STATUS_SUDAH_DIBAYAR;
        $transaksi->save();

        return redirect()->route('transaksipembelianbahanbaku.index')->with('success', 'Transaksi berhasil dibayar');
    }

    /**
     * Menghapus transaksi berdasarkan ID.
     * 
     * @param int $id ID transaksi yang ingin dihapus
     */
    public function destroy($id)
    {
        $transaksi = TransaksiPembelianBahanBaku::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksipembelianbahanbaku.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
