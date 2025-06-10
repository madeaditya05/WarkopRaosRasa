<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPembelianBahanBaku;
use App\Models\DetailTransaksiPembelianBahanBaku;
use App\Models\Supplier;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiPembelianBahanBakuController extends Controller
{
    public function index()
    {
        // Variabel compact harus sama nama variabelnya
        $transaksis = TransaksiPembelianBahanBaku::with(['supplier', 'details.bahanBaku'])->get();
        return view('transaksipembelianbahanbaku.index', compact('transaksis'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $bahanBakus = BahanBaku::all();
        return view('transaksipembelianbahanbaku.create', compact('suppliers', 'bahanBakus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id', // tabel suppliers plural
            'tanggal' => 'required|date',
            'bahan_baku_id.*' => 'required|exists:bahan_bakus,id', // tabel bahan_bakus plural
            'jumlah.*' => 'required|numeric|min:1',
        ]);

        DB::transaction(function () use ($request) {
            // Simpan transaksi utama
            $transaksi = TransaksiPembelianBahanBaku::create([
                'supplier_id' => $request->supplier_id,
                'tanggal' => $request->tanggal,
                'subtotal' => 0 // akan dihitung nanti
            ]);

            $total = 0;

            // Simpan detail dan update stok
            foreach ($request->bahan_baku_id as $i => $bahan_id) {
                $bahan = BahanBaku::findOrFail($bahan_id);
                $jumlah = $request->jumlah[$i];
                $subtotal = $jumlah * $bahan->harga_per_satuan;
                $total += $subtotal;

                DetailTransaksiPembelianBahanBaku::create([
                    'transaksi_pembelian_id' => $transaksi->id,
                    'bahan_baku_id' => $bahan_id,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $bahan->harga_per_satuan,
                    'subtotal' => $subtotal,
                ]);

                // Update stok bahan baku menggunakan increment agar aman
                $bahan->increment('jumlah', $jumlah);
            }

            // Update subtotal transaksi
            $transaksi->subtotal = $total;
            $transaksi->save();
        });

        // Redirect ke bahanbaku.index karena kamu mau lihat data bahan baku yg sudah terupdate stoknya
        return redirect()->route('bahanbaku.index')->with('success', 'Transaksi berhasil disimpan dan stok diperbarui.');
    }

    public function bayar($id)
    {
        $transaksi = TransaksiPembelianBahanBaku::findOrFail($id);
        $transaksi->status = TransaksiPembelianBahanBaku::STATUS_SUDAH_DIBAYAR;
        $transaksi->save();

        return redirect()->route('transaksipembelianbahanbaku.index')->with('success', 'Transaksi berhasil dibayar');
    }

    public function destroy($id)
    {
        $transaksi = TransaksiPembelianBahanBaku::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksipembelianbahanbaku.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
