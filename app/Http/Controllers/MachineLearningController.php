<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Phpml\Clustering\KMeans;

class MachineLearningController extends Controller
{
    public function clusteringChart()
{
    // Ambil data penjualan
    $penjualanOnline = DB::table('transaksi')
        ->select(DB::raw('MONTH(created_at) as bulan'), DB::raw('SUM(total) as total'))
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

    $penjualanOffline = DB::table('transaksi_offline')
        ->select(DB::raw('MONTH(tanggal_pesan) as bulan'), DB::raw('SUM(total_harga) as total'))
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

    // Siapkan data gabungan: [online, offline]
    $data = [];
    $labels = [];

    for ($i = 1; $i <= 12; $i++) {
        $online = $penjualanOnline->firstWhere('bulan', $i);
        $offline = $penjualanOffline->firstWhere('bulan', $i);

        $data[] = [
            (float) ($online->total ?? 0),
            (float) ($offline->total ?? 0),
        ];
        $labels[] = "Bulan $i";
    }

    // Jalankan K-Means
    $kmeans = new KMeans(3);
    $clusters = $kmeans->cluster($data);

    // Siapkan data untuk Chart.js (warna per cluster)
    $chartData = [];

    foreach ($clusters as $clusterIndex => $cluster) {
        foreach ($cluster as $point) {
            $chartData[] = [
                'online' => $point[0],
                'offline' => $point[1],
                'cluster' => $clusterIndex + 1,
            ];
        }
    }

    return view('ml.clustering-chart', [
        'chartData' => $chartData,
        'labels' => $labels,
    ]);
}
}