<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiOfflineDetail;
use App\Models\TransaksiOffline;
use App\Models\DetailTransaksiPembelianBahanBaku;
use App\Models\TransaksiPembelianBahanBaku;
use App\Models\Gaji; // pastikan kamu sudah punya model ini
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanJurnalController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $tipe = $request->input('tipe', 'semua');

        $data = [];

        // Penjualan (Kas & Penjualan)
        if ($tipe == 'semua' || $tipe == 'penjualan') {
            $penjualanDetails = TransaksiOfflineDetail::with('transaksiOffline')
                ->whereHas('transaksiOffline', function ($q) use ($bulan, $tahun) {
                    if ($bulan && $tahun) {
                        $q->whereMonth('tanggal_pesan', $bulan)->whereYear('tanggal_pesan', $tahun);
                    }
                })->get();

            foreach ($penjualanDetails as $item) {
                $tanggal = $item->transaksiOffline->tanggal_pesan;
                $faktur = $item->transaksiOffline->no_faktur;
                $subtotal = $item->subtotal;

                $data[] = [
                    'tanggal' => $tanggal,
                    'no_faktur' => $faktur,
                    'keterangan' => 'Kas',
                    'ref' => '101',
                    'debit' => $subtotal,
                    'kredit' => 0,
                ];
                $data[] = [
                    'tanggal' => $tanggal,
                    'no_faktur' => $faktur,
                    'keterangan' => 'Penjualan',
                    'ref' => '401',
                    'debit' => 0,
                    'kredit' => $subtotal,
                ];
            }
        }

        // Penggajian
        if ($tipe == 'semua' || $tipe == 'penggajian') {
            $penggajians = Gaji::when($bulan && $tahun, function ($q) use ($bulan, $tahun) {
                $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            })->get();

            foreach ($penggajians as $gaji) {
                $data[] = [
                    'tanggal' => $gaji->tanggal,
                    'no_faktur' => 'GJ-' . $gaji->id,
                    'keterangan' => 'Beban Gaji',
                    'ref' => '501',
                    'debit' => $gaji->total_gaji,
                    'kredit' => 0,
                ];
                $data[] = [
                    'tanggal' => $gaji->tanggal,
                    'no_faktur' => 'GJ-' . $gaji->id,
                    'keterangan' => 'Kas',
                    'ref' => '101',
                    'debit' => 0,
                    'kredit' => $gaji->total_gaji,
                ];
            }
        }

        // Pembelian Bahan Baku
        if ($tipe == 'semua' || $tipe == 'pembelian') {
            $pembelianDetails = DetailTransaksiPembelianBahanBaku::with('transaksiPembelian')
                ->whereHas('transaksiPembelian', function ($q) use ($bulan, $tahun) {
                    if ($bulan && $tahun) {
                        $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
                    }
                })->get();

            foreach ($pembelianDetails as $item) {
                $tanggal = $item->transaksiPembelian->tanggal;
                $faktur = 'PB-' . $item->transaksiPembelian->id;
                $subtotal = $item->subtotal;

                $data[] = [
                    'tanggal' => $tanggal,
                    'no_faktur' => $faktur,
                    'keterangan' => 'Persediaan Bahan Baku',
                    'ref' => '103',
                    'debit' => $subtotal,
                    'kredit' => 0,
                ];
                $data[] = [
                    'tanggal' => $tanggal,
                    'no_faktur' => $faktur,
                    'keterangan' => 'Kas',
                    'ref' => '101',
                    'debit' => 0,
                    'kredit' => $subtotal,
                ];
            }
        }

        // Urutkan berdasarkan tanggal
        usort($data, fn($a, $b) => strtotime($a['tanggal']) <=> strtotime($b['tanggal']));

        return view('laporan.jurnal', compact('data', 'bulan', 'tahun', 'tipe'));
    }

    /**
     * Export PDF dari jurnal
     */
    public function exportPdf(Request $request)
{
    $bulan = $request->input('bulan');
    $tahun = $request->input('tahun');
    $jenis = $request->input('jenis_jurnal', 'semua');

    $transaksis = collect();
    $penggajians = collect();
    $pembelians = collect();

    if ($jenis === 'semua' || $jenis === 'penjualan') {
        $transaksis = TransaksiOffline::with('details.menuMakanan')
            ->when($bulan && $tahun, function ($q) use ($bulan, $tahun) {
                return $q->whereMonth('tanggal_pesan', $bulan)
                         ->whereYear('tanggal_pesan', $tahun);
            })
            ->orderBy('tanggal_pesan')
            ->get();
    }

    if ($jenis === 'semua' || $jenis === 'penggajian') {
        $penggajians = Gaji::when($bulan && $tahun, function ($q) use ($bulan, $tahun) {
            return $q->whereMonth('tanggal', $bulan)
                     ->whereYear('tanggal', $tahun);
        })
        ->orderBy('tanggal')
        ->get();
    }

    if ($jenis === 'semua' || $jenis === 'pembelian') {
        $pembelians = TransaksiPembelianBahanBaku::with('details')
            ->when($bulan && $tahun, function ($q) use ($bulan, $tahun) {
                return $q->whereMonth('tanggal', $bulan)
                         ->whereYear('tanggal', $tahun);
            })
            ->orderBy('tanggal')
            ->get();
    }

    $pdf = Pdf::loadView('laporan.jurnal_pdf', compact('transaksis', 'penggajians', 'pembelians', 'bulan', 'tahun', 'jenis'))
              ->setPaper('A4', 'portrait');

    return $pdf->download('laporan_jurnal_' . now()->format('Ymd_His') . '.pdf');
}   

    /**
     * Detail transaksi penjualan
     */
    public function show($id)
    {
        $transaksi = TransaksiOffline::with('details.menuMakanan')->findOrFail($id);
        return view('laporan.show', compact('transaksi'));
    }
}
