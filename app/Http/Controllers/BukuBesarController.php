<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiOffline;
use PDF;

class BukuBesarController extends Controller
{
    public function index(Request $request)
    {
        $bukuBesar = $this->getBukuBesar($request);

        // Kirim pilihan akun juga ke view untuk dropdown
        $akunKasDanPenjualan = ['Kas', 'Penjualan'];
        
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
        $query = TransaksiOffline::with('details');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pesan', $request->tanggal);
        }

        $transaksis = $query->orderBy('tanggal_pesan')->get();

        $bukuBesar = [];

        // Filter akun dari request, default null (semua)
        $filterAkun = $request->input('akun'); // Contoh: 'Kas' atau 'Penjualan'

        foreach ($transaksis as $transaksi) {
            $tanggal = $transaksi->tanggal_pesan;
            $faktur = $transaksi->no_faktur;
            $total = $transaksi->total_harga;

            // Jika filter akun dipilih, cek dulu apakah transaksi masuk akun tsb
            if (!$filterAkun || $filterAkun == 'Kas') {
                $bukuBesar['Kas'][] = [
                    'tanggal' => $tanggal,
                    'keterangan' => "Penjualan Offline ($faktur)",
                    'ref' => 'Jurnal',
                    'debit' => $total,
                    'kredit' => 0
                ];
            }

            if (!$filterAkun || $filterAkun == 'Penjualan') {
                $bukuBesar['Penjualan'][] = [
                    'tanggal' => $tanggal,
                    'keterangan' => "Penjualan Offline ($faktur)",
                    'ref' => 'Jurnal',
                    'debit' => 0,
                    'kredit' => $total
                ];
            }
        }

        // Jika filter akun dipilih, hapus akun lain supaya di view hanya tampil akun yang dipilih
        if ($filterAkun) {
            $bukuBesar = [
                $filterAkun => $bukuBesar[$filterAkun] ?? []
            ];
        }

        return $bukuBesar;
    }
}
