<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuMakanan;
use App\Models\Transaksi;
use App\Services\MidtransService;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = session()->get('keranjang', []);
        return view('keranjang.index', compact('keranjang'));
    }

    public function store(Request $request)
{
    // Ambil data menu berdasarkan ID
    $menu = MenuMakanan::findOrFail($request->id);
    
    // Ambil keranjang yang ada di session atau buat baru
    $keranjang = session()->get('keranjang', []);

    // Ambil jumlah produk dari request
    $jumlah = $request->jumlah;

    // Jika item sudah ada di keranjang, update jumlahnya
    if (isset($keranjang[$menu->id])) {
        $keranjang[$menu->id]['jumlah'] += $jumlah;  // Menambahkan jumlah produk
    } else {
        // Jika item baru, tambahkan ke keranjang
        $keranjang[$menu->id] = [
            'nama' => $menu->nama_menu,
            'harga' => $menu->harga,
            'jumlah' => $jumlah,
            'foto' => $menu->foto
        ];
    }

    // Simpan kembali keranjang ke session
    session()->put('keranjang', $keranjang);

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}


    public function update(Request $request, $id)
{
    $keranjang = session()->get('keranjang', []);

    if (!isset($keranjang[$id])) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    if ($request->action === 'increase') {
        $keranjang[$id]['jumlah'] += 1;
    } elseif ($request->action === 'decrease') {
        $keranjang[$id]['jumlah'] -= 1;
        if ($keranjang[$id]['jumlah'] < 1) {
            unset($keranjang[$id]); // hapus dari keranjang kalau jumlah 0
        }
    }

    session()->put('keranjang', $keranjang);

    return redirect()->back()->with('success', 'Keranjang diperbarui.');
}


    public function destroy($id)
    {
        $keranjang = session()->get('keranjang', []);
        unset($keranjang[$id]);
        session()->put('keranjang', $keranjang);

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function checkout()
    {
        $keranjang = session()->get('keranjang');

        if (!$keranjang || count($keranjang) === 0) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        $total = array_sum(array_map(fn($item) => $item['harga'] * $item['jumlah'], $keranjang));
        $orderId = 'INV-' . time();

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'item_details' => collect($keranjang)->map(function ($item, $id) {
                return [
                    'id' => $id,
                    'price' => $item['harga'],
                    'quantity' => $item['jumlah'],
                    'name' => $item['nama'],
                ];
            })->values()->toArray()
        ];

        $snap = MidtransService::createTransaction($payload);

        Transaksi::create([
            'order_id' => $orderId,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total' => $total,
            'keranjang_data' => json_encode($keranjang),
        ]);

        return redirect($snap->redirect_url);
    }
}
