<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf;

class GajiController extends Controller
{
    // Menampilkan daftar gaji dan rekap bulanan
    public function index(Request $request)
    {
        $daftarBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $bulan = $request->bulan ?? date('n');
        $tahun = $request->tahun ?? date('Y');

        $dataGaji = Gaji::with('karyawan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $totalGaji = $dataGaji->sum('total_gaji');

        return view('gaji.index', compact('dataGaji', 'bulan', 'tahun', 'daftarBulan', 'totalGaji'));
    }

    // Form tambah gaji
    public function create()
    {
        $karyawan = Karyawan::all();
        return view('gaji.create', compact('karyawan'));
    }

    // Simpan gaji ke database
    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'tanggal' => 'required|date',
            'gaji_pokok' => 'required|numeric',
            'tunjangan' => 'required|numeric',
        ]);

        $tunjangan = $request->tunjangan;
        $totalGaji = $request->gaji_pokok + $tunjangan;

        Gaji::create([
            'karyawan_id' => $request->karyawan_id,
            'tanggal' => $request->tanggal,
            'gaji_pokok' => $request->gaji_pokok,
            'tunjangan' => $tunjangan,
            'total_gaji' => $totalGaji,
            'status' => 'Terbayar',
        ]);

        return redirect()->route('gaji.index')->with('success', 'Gaji berhasil ditambahkan.');
    }

    public function exportPDF(Request $request)
{
    $bulan = $request->bulan ?? date('n');
    $tahun = $request->tahun ?? date('Y');

    $dataGaji = Gaji::with('karyawan')
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->get();

    $totalGaji = $dataGaji->sum('total_gaji');
    $daftarBulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    $pdf = Pdf::loadView('gaji.pdf', compact('dataGaji', 'bulan', 'tahun', 'daftarBulan', 'totalGaji'));
    return $pdf->download("rekap_gaji_{$bulan}_{$tahun}.pdf");
}
}
