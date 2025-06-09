<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->input('periode', 'bulan');

        // ===========================
        // Range waktu untuk filter data (digunakan untuk semua box dan grafik)
        // ===========================
         if ($periode === 'minggu') {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek(); // Fix penting
        } elseif ($periode === 'tahun') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth(); // Fix penting
    }

        // ===========================
        // PENJUALAN ONLINE
        // ===========================
        if ($periode === 'minggu') {
            $penjualan_online = DB::table('transaksi')
                ->selectRaw('DATE(created_at) as hari, SUM(total) as total')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupByRaw('DATE(created_at)')
                ->orderByRaw('DATE(created_at)')
                ->get();

            $labelsPenjualanOnline = $penjualan_online->pluck('hari')->map(fn($h) => Carbon::parse($h)->translatedFormat('D, d M'));
        } elseif ($periode === 'tahun') {
            $penjualan_online = DB::table('transaksi')
                ->selectRaw('MONTH(created_at) as bulan, SUM(total) as total')
                ->whereYear('created_at', Carbon::now()->year)
                ->groupByRaw('MONTH(created_at)')
                ->orderByRaw('MONTH(created_at)')
                ->get();

            $labelsPenjualanOnline = $penjualan_online->pluck('bulan')->map(fn($b) => Carbon::create()->month($b)->translatedFormat('F'));
        } else {
            $penjualan_online = DB::table('transaksi')
                ->selectRaw('DAY(created_at) as hari, SUM(total) as total')
                ->whereMonth('created_at', Carbon::now()->month)
                ->groupByRaw('DAY(created_at)')
                ->orderByRaw('DAY(created_at)')
                ->get();

            $labelsPenjualanOnline = $penjualan_online->pluck('hari')->map(fn($d) => 'Tgl ' . $d);
        }
        $dataPenjualanOnline = $penjualan_online->pluck('total');

        // ===========================
        // PENJUALAN OFFLINE
        // ===========================
        if ($periode === 'minggu') {
            $penjualan_offline = DB::table('transaksi_offline')
                ->selectRaw('DATE(tanggal_pesan) as hari, SUM(total_harga) as total')
                ->whereBetween('tanggal_pesan', [$startDate, $endDate])
                ->groupByRaw('DATE(tanggal_pesan)')
                ->orderByRaw('DATE(tanggal_pesan)')
                ->get();

            $labelsPenjualanOffline = $penjualan_offline->pluck('hari')->map(fn($h) => Carbon::parse($h)->translatedFormat('D, d M'));
        } elseif ($periode === 'tahun') {
            $penjualan_offline = DB::table('transaksi_offline')
                ->selectRaw('MONTH(tanggal_pesan) as bulan, SUM(total_harga) as total')
                ->whereYear('tanggal_pesan', Carbon::now()->year)
                ->groupByRaw('MONTH(tanggal_pesan)')
                ->orderByRaw('MONTH(tanggal_pesan)')
                ->get();

            $labelsPenjualanOffline = $penjualan_offline->pluck('bulan')->map(fn($b) => Carbon::create()->month($b)->translatedFormat('F'));
        } else {
            $penjualan_offline = DB::table('transaksi_offline')
                ->selectRaw('DAY(tanggal_pesan) as hari, SUM(total_harga) as total')
                ->whereMonth('tanggal_pesan', Carbon::now()->month)
                ->groupByRaw('DAY(tanggal_pesan)')
                ->orderByRaw('DAY(tanggal_pesan)')
                ->get();

            $labelsPenjualanOffline = $penjualan_offline->pluck('hari')->map(fn($d) => 'Tgl ' . $d);
        }
        $dataPenjualanOffline = $penjualan_offline->pluck('total');


        // ===========================
        // PEMBELIAN BAHAN BAKU
        // ===========================
        $pembelian = DB::table('transaksi_pembelian_bahan_baku')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->selectRaw('DATE(tanggal) as hari, SUM(subtotal) as total')
            ->groupByRaw('DATE(tanggal)')
            ->orderByRaw('DATE(tanggal)')
            ->get();

        $labelsPembelian = $pembelian->pluck('hari')->map(fn($h) => Carbon::parse($h)->translatedFormat('d M'));
        $dataPembelian = $pembelian->pluck('total');

        // ===========================
        // MENU TERLARIS (TOP 5)
        // ===========================
        $menu = DB::table('menu_makanan')
            ->orderByDesc('terjual')
            ->limit(5)
            ->get();

        $labelsMenu = $menu->pluck('nama_menu');
        $dataMenu = $menu->pluck('terjual');

        // ===========================
        // STOK BAHAN BAKU
        // ===========================
        $bahan = DB::table('bahan_baku')->get();
        $labelsBahan = $bahan->pluck('nama_bahan');
        $dataBahan = $bahan->pluck('jumlah');

        // ===========================
        // DATA SUMMARY BOX (Jumlah Pembeli, Transaksi, Total Penjualan, Total Keuntungan)
        // ===========================
        $jumlahPembeli = DB::table('pelanggan')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $jumlahTransaksiOnline = DB::table('transaksi')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        
        $jumlahTransaksiOffline = DB::table('transaksi_offline')
            ->whereBetween('tanggal_pesan', [$startDate, $endDate])
            ->count();
        
        $jumlahTransaksi=$jumlahTransaksiOffline + $jumlahTransaksiOnline;   

        $totalPenjualanOnline = DB::table('transaksi')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');

        $totalPenjualanOffline = DB::table('transaksi_offline')
            ->whereBetween('tanggal_pesan', [$startDate, $endDate])
            ->sum('total_harga'); 

        $totalPenjualan = $totalPenjualanOnline + $totalPenjualanOffline;

        $totalKeuntungan = $totalPenjualan * 0.2;

        return view('dashboard.index', compact(
            'labelsPenjualanOnline', 'dataPenjualanOnline',
            'labelsPenjualanOffline', 'dataPenjualanOffline',
            'labelsPembelian', 'dataPembelian',
            'labelsMenu', 'dataMenu',
            'labelsBahan', 'dataBahan',
            'jumlahPembeli', 'jumlahTransaksi', 'totalPenjualan', 'totalKeuntungan',
            'periode'
        ));
    }
}
