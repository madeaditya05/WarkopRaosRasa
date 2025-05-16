<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\MenuMakanan;
use App\Models\Pelanggan;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua transaksi dari database
        $transaksis = Transaksi::with('details')->get();
        return view('penjualan.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua menu makanan dan pelanggan dari database
        $menuMakanan = MenuMakanan::all();
        $pelanggan = Pelanggan::all();
        return view('penjualan.create', compact('menuMakanan', 'pelanggan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang dikirimkan dari form
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'menu_makanan_id' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        // Generate no faktur otomatis
        $noFaktur = 'F' . time();

        // Simpan transaksi ke tabel transaksis
        $transaksi = Transaksi::create([
            'no_faktur' => $noFaktur,
            'pelanggan_id' => $validated['pelanggan_id'],
            'tanggal_pesan' => now(),
            'total_harga' => 0, // Total harga akan dihitung nanti
        ]);

        $totalHarga = 0;

        // Simpan detail transaksi
        foreach ($validated['menu_makanan_id'] as $index => $menuMakananId) {
            $menuMakanan = MenuMakanan::find($menuMakananId);
            $jumlah = $validated['jumlah'][$index];

            // Cek jika stok cukup
            if ($menuMakanan->stok < $jumlah) {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk menu ' . $menuMakanan->nama_menu);
            }

            // Hitung subtotal
            $subtotal = $menuMakanan->harga * $jumlah;
            $totalHarga += $subtotal;

            // Kurangi stok dan tambah jumlah yang terjual
            $menuMakanan->stok -= $jumlah;
            $menuMakanan->terjual += $jumlah;
            $menuMakanan->save();

            // Simpan detail transaksi (menu yang dibeli)
            $transaksi->details()->create([
                'menu_makanan_id' => $menuMakananId,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
            ]);
        }

        // Update total harga transaksi
        $transaksi->update(['total_harga' => $totalHarga]);

        // Redirect ke halaman transaksi setelah berhasil
        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        return view('penjualan.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        // Ambil data menu makanan dan pelanggan untuk form edit
        $menuMakanan = MenuMakanan::all();
        $pelanggan = Pelanggan::all();
        return view('penjualan.edit', compact('transaksi', 'menuMakanan', 'pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        // Validasi data yang dikirimkan dari form
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'menu_makanan_id' => 'required|array',
            'jumlah' => 'required|array',
        ]);

        // Reset total harga dan details transaksi lama
        $transaksi->details()->delete();
        $totalHarga = 0;

        // Simpan detail transaksi yang diperbarui
        foreach ($validated['menu_makanan_id'] as $index => $menuMakananId) {
            $menuMakanan = MenuMakanan::find($menuMakananId);
            $jumlah = $validated['jumlah'][$index];

            // Cek jika stok cukup
            if ($menuMakanan->stok < $jumlah) {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk menu ' . $menuMakanan->nama_menu);
            }

            // Hitung subtotal
            $subtotal = $menuMakanan->harga * $jumlah;
            $totalHarga += $subtotal;

            // Kurangi stok dan tambah jumlah yang terjual
            $menuMakanan->stok -= $jumlah;
            $menuMakanan->terjual += $jumlah;
            $menuMakanan->save();

            // Simpan detail transaksi (menu yang dibeli)
            $transaksi->details()->create([
                'menu_makanan_id' => $menuMakananId,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
            ]);
        }

        // Update total harga transaksi
        $transaksi->update(['total_harga' => $totalHarga]);

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cari transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);

        // Kembalikan stok dan terjual untuk setiap menu yang ada dalam detail transaksi
        foreach ($transaksi->details as $detail) {
            $menuMakanan = $detail->menuMakanan;
            $menuMakanan->stok += $detail->jumlah;
            $menuMakanan->terjual -= $detail->jumlah;
            $menuMakanan->save();
        }

        // Hapus transaksi dan detailnya
        $transaksi->details()->delete();
        $transaksi->delete();

        return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
