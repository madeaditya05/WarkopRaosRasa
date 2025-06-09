<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    
use Midtrans\Notification;
use App\Models\Transaksi;
use App\Models\DetailTransaksiOnline;
use App\Models\MenuMakanan;

class MidtransController extends Controller
{
    public function callback(Request $request)
{
    // Inisialisasi notifikasi dari Midtrans
    $notif = new Notification();

    // Cari transaksi berdasarkan order_id
    $transaksi = Transaksi::where('order_id', $notif->order_id)->first();

    if (!$transaksi) {
        return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
    }

    // Cek status pembayaran
    if ($notif->transaction_status === 'settlement') {
        $transaksi->status = 'success';
        $transaksi->save();

        // Simpan ke detail_transaksi_online & update stok
        $keranjang = json_decode($transaksi->keranjang_data, true);

        foreach ($keranjang as $id => $item) {
            // Simpan detail transaksi
           DetailTransaksiOnline::create([
                'transaksi_id' => $transaksi->id,
                'menu_makanan_id' => $id,
                'jumlah' => $item['jumlah'],
                'harga' => $item['harga'],
                'subtotal' => $item['jumlah'] * $item['harga'],
            ]);

            // Kurangi stok dan tambah terjual
            $menu = MenuMakanan::find($id);
            if ($menu) {
                $menu->stok -= $item['jumlah'];
                $menu->terjual += $item['jumlah'];
                $menu->save();
            }
        }

    } elseif (in_array($notif->transaction_status, ['expire', 'cancel', 'deny'])) {
        $transaksi->status = 'failed';
        $transaksi->save();
    }

    return response()->json(['message' => 'Callback diproses']);
}

}
