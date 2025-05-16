<?php

// app/Http/Controllers/PembelianBahanBakuController.php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\BahanBaku;
use App\Models\TransaksiPembelianBahanBaku;
use App\Models\DetailTransaksiPembelianBahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PembelianExport;
use Maatwebsite\Excel\Facades\Excel;

class PembelianBahanBakuController extends Controller
{
    public function create()
    {
        $suppliers = Supplier::all();
        $bahanBakus = BahanBaku::all();
        return view('pembelianbahanbaku.create', compact('suppliers', 'bahanBakus'));
    }

    public function show($id)
    {
        $transaksi = TransaksiPembelianBahanBaku::with('supplier', 'details.bahanBaku')->findOrFail($id);
        return view('pembelian.show', compact('transaksi'));
    }

    public function exportPDF($id)
    {
        $transaksi = TransaksiPembelianBahanBaku::with('supplier', 'details.bahanBaku')->findOrFail($id);
        $pdf = PDF::loadView('pembelian.pdf', compact('transaksi'));
        return $pdf->download('transaksi-pembelian-'.$id.'.pdf');
    }


    public function store(Request $request)
{
    $request->validate([
        'supplier_id' => 'required|exists:supplier,id',
        'tanggal' => 'required|date',
        'items.*.bahan_baku_id' => 'required|exists:bahan_baku,id',
        'items.*.jumlah' => 'required|integer|min:1',
        'items.*.harga_satuan' => 'required|integer|min:0',
    ]);

    DB::transaction(function () use ($request) {
        // Inisialisasi subtotal total
        $subtotalTotal = 0;

        // Buat transaksi terlebih dahulu
        $transaksi = TransaksiPembelianBahanBaku::create([
            'supplier_id' => $request->supplier_id,
            'tanggal' => $request->tanggal,
            'subtotal' => 0, // sementara 0, akan diupdate nanti
        ]);

        // Simpan setiap detail dan hitung subtotalnya
        foreach ($request->items as $item) {
            $subtotal = $item['jumlah'] * $item['harga_satuan'];
            $subtotalTotal += $subtotal;

            DetailTransaksiPembelianBahanBaku::create([
                'transaksi_id' => $transaksi->id,
                'bahan_baku_id' => $item['bahan_baku_id'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga_satuan'],
                'subtotal' => $subtotal,
            ]);
        }

        // Update subtotal total ke transaksi
        $transaksi->update([
            'subtotal' => $subtotalTotal,
        ]);
    });

    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan');
}

public function exportIndexPDF()
{
    $transaksis = TransaksiPembelianBahanBaku::with('supplier')->get();
    $pdf = PDF::loadView('transaksipembelianbahanbaku.pdf', compact('transaksis'))->setPaper('a4', 'landscape');
    return $pdf->download('daftar-transaksi-pembelian.pdf');
}


}