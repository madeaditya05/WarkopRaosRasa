<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiOffline;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class BukuBesarController extends Controller
{
    public function index(Request $request)
    {
        $bukuBesar = $this->getBukuBesar($request);
        $akunKasDanPenjualan = ['Kas', 'Penjualan', 'Pembelian Bahan Baku', 'Gaji'];

        return view('buku-besar.index', compact('bukuBesar', 'akunKasDanPenjualan'));
    }

    public function export(Request $request)
    {
        $bukuBesar = $this->getBukuBesar($request);

        $pdf = PDF::loadView('buku-besar.pdf', compact('bukuBesar'))->setPaper('A4', 'portrait');
        return $pdf->download('laporan_buku_besar.pdf');
    }

    private function getBukuBesar(Request $request)
    {
        $tanggalFilter = $request->input('tanggal');
        $filterAkun = $request->input('akun');

        $bukuBesar = [];

        // 1. Penjualan
        $penjualan = TransaksiOffline::query();
        if ($tanggalFilter) $penjualan->whereDate('tanggal_pesan', $tanggalFilter);

        foreach ($penjualan->get() as $trx) {
            if (!$filterAkun || $filterAkun == 'Kas') {
                $bukuBesar['Kas'][] = [
                    'tanggal' => $trx->tanggal_pesan,
                    'keterangan' => "Penjualan Offline ({$trx->no_faktur})",
                    'ref' => 'Jurnal',
                    'debit' => $trx->total_harga,
                    'kredit' => 0
                ];
            }
            if (!$filterAkun || $filterAkun == 'Penjualan') {
                $bukuBesar['Penjualan'][] = [
                    'tanggal' => $trx->tanggal_pesan,
                    'keterangan' => "Penjualan Offline ({$trx->no_faktur})",
                    'ref' => 'Jurnal',
                    'debit' => 0,
                    'kredit' => $trx->total_harga
                ];
            }
        }

        // 2. Pembelian
        $pembelian = DB::table('transaksi_pembelian_bahan_baku');
        if ($tanggalFilter) $pembelian->whereDate('tanggal', $tanggalFilter);

        foreach ($pembelian->get() as $trx) {
            if (!$filterAkun || $filterAkun == 'Kas') {
                $bukuBesar['Kas'][] = [
                    'tanggal' => $trx->tanggal,
                    'keterangan' => "Pembelian Bahan Baku (#{$trx->id})",
                    'ref' => 'Jurnal',
                    'debit' => 0,
                    'kredit' => $trx->subtotal
                ];
            }
            if (!$filterAkun || $filterAkun == 'Pembelian Bahan Baku') {
                $bukuBesar['Pembelian Bahan Baku'][] = [
                    'tanggal' => $trx->tanggal,
                    'keterangan' => "Pembelian Bahan Baku (#{$trx->id})",
                    'ref' => 'Jurnal',
                    'debit' => $trx->subtotal,
                    'kredit' => 0
                ];
            }
        }

        // 3. Gaji
        $gaji = DB::table('gaji');
        if ($tanggalFilter) $gaji->whereDate('tanggal', $tanggalFilter);

        foreach ($gaji->get() as $row) {
            if (!$filterAkun || $filterAkun == 'Kas') {
                $bukuBesar['Kas'][] = [
                    'tanggal' => $row->tanggal,
                    'keterangan' => "Pembayaran Gaji (Karyawan ID {$row->karyawan_id})",
                    'ref' => 'Jurnal',
                    'debit' => 0,
                    'kredit' => $row->total_gaji
                ];
            }
            if (!$filterAkun || $filterAkun == 'Gaji') {
                $bukuBesar['Gaji'][] = [
                    'tanggal' => $row->tanggal,
                    'keterangan' => "Pembayaran Gaji (Karyawan ID {$row->karyawan_id})",
                    'ref' => 'Jurnal',
                    'debit' => $row->total_gaji,
                    'kredit' => 0
                ];
            }
        }

        // Filter akun spesifik
        if ($filterAkun) {
            $bukuBesar = [$filterAkun => $bukuBesar[$filterAkun] ?? []];
        }

        return $bukuBesar;
    }
}
