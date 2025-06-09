<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiOffline;
use App\Models\TransaksiOfflineDetail;
use App\Models\MenuMakanan;
use App\Models\Pelanggan;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Mail\TransaksiOfflineSuccessMail;
use Illuminate\Support\Facades\Mail;



class TransaksiOfflineController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiOffline::with('pelanggan', 'details.menuMakanan')->latest()->get();
        return view('TransaksiOffline.index', compact('transaksi'));
    }

    
    
    public function exportPdf()
    {
        $transaksi = TransaksiOffline::with('pelanggan', 'details.menuMakanan')->latest()->get();

        $pdf = Pdf::loadView('TransaksiOffline.pdf', compact('transaksi'))
                  ->setPaper('A4', 'portrait');

        return $pdf->download('transaksi_offline_' . now()->format('Ymd_His') . '.pdf');
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        $menu_makanan = MenuMakanan::where('stok', '>', 0)->get();
        $no_faktur = 'PJ-' . strtoupper(Str::random(6));
        $tanggal = Carbon::now();

        return view('TransaksiOffline.create', compact('pelanggan', 'menu_makanan', 'no_faktur', 'tanggal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_faktur'         => 'required|unique:transaksi_offline',
            'tanggal_pesan'     => 'required|date',
            'pelanggan_id'      => 'required|exists:pelanggan,id',
            'menu_makanan_id'   => 'required|array',
            'menu_makanan_id.*' => 'exists:menu_makanan,id',
            'jumlah'            => 'required|array',
            'jumlah.*'          => 'integer|min:1',
        ]);

        if (count($request->menu_makanan_id) !== count($request->jumlah)) {
            return back()->withErrors('Jumlah item dan jumlah pesanan tidak cocok.');
        }

        DB::beginTransaction();

        try {
            $total = 0;
            foreach ($request->menu_makanan_id as $index => $menuId) {
                $menu    = MenuMakanan::findOrFail($menuId);
                $jumlah  = $request->jumlah[$index];
                $subtotal = $menu->harga * $jumlah;
                $total   += $subtotal;
            }

            $transaksi = TransaksiOffline::create([
                'no_faktur'     => $request->no_faktur,
                'tanggal_pesan' => $request->tanggal_pesan,
                'pelanggan_id'  => $request->pelanggan_id,
                'total_harga'   => $total,
            ]);

            foreach ($request->menu_makanan_id as $index => $menuId) {
                $menu    = MenuMakanan::findOrFail($menuId);
                $jumlah  = $request->jumlah[$index];
                $subtotal = $menu->harga * $jumlah;

                TransaksiOfflineDetail::create([
                    'transaksi_offline_id' => $transaksi->id,
                    'menu_makanan_id'      => $menuId,
                    'jumlah'               => $jumlah,
                    'subtotal'             => $subtotal,
                ]);

                $menu->decrement('stok', $jumlah);
                $menu->increment('terjual', $jumlah);
            }

            DB::commit();

            if (!empty($transaksi->pelanggan?->email)) {
                Mail::to($transaksi->pelanggan->email)
                    ->send(new TransaksiOfflineSuccessMail($transaksi));
            }

            return redirect()->route('TransaksiOffline.index')
                             ->with('success', 'Transaksi berhasil disimpan & email (jika ada) telah dikirim');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $transaksi = TransaksiOffline::with('details.menuMakanan')->findOrFail($id);
        $pelanggan = Pelanggan::all();
        $menu_makanan = MenuMakanan::where('stok', '>', 0)->get();

        return view('TransaksiOffline.edit', compact('transaksi', 'pelanggan', 'menu_makanan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal_pesan'     => 'required|date',
            'pelanggan_id'      => 'required|exists:pelanggan,id',
            'menu_makanan_id'   => 'required|array',
            'menu_makanan_id.*' => 'exists:menu_makanan,id',
            'jumlah'            => 'required|array',
            'jumlah.*'          => 'integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $transaksi = TransaksiOffline::with('details')->findOrFail($id);

            // Restore stok
            foreach ($transaksi->details as $detail) {
                $menu = MenuMakanan::find($detail->menu_makanan_id);
                if ($menu) {
                    $menu->increment('stok', $detail->jumlah);
                    $menu->decrement('terjual', $detail->jumlah);
                }
            }

            // Hapus detail lama
            $transaksi->details()->delete();

            // Hitung ulang total dan buat detail baru
            $total = 0;
            foreach ($request->menu_makanan_id as $index => $menuId) {
                $menu     = MenuMakanan::findOrFail($menuId);
                $jumlah   = $request->jumlah[$index];
                $subtotal = $menu->harga * $jumlah;
                $total   += $subtotal;

                TransaksiOfflineDetail::create([
                    'transaksi_offline_id' => $transaksi->id,
                    'menu_makanan_id'      => $menuId,
                    'jumlah'               => $jumlah,
                    'subtotal'             => $subtotal,
                ]);

                $menu->decrement('stok', $jumlah);
                $menu->increment('terjual', $jumlah);
            }

            // Update transaksi utama
            $transaksi->update([
                'tanggal_pesan' => $request->tanggal_pesan,
                'pelanggan_id'  => $request->pelanggan_id,
                'total_harga'   => $total,
            ]);

            DB::commit();

            return redirect()->route('TransaksiOffline.index')
                             ->with('success', 'Transaksi berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Gagal memperbarui transaksi: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $transaksi_offline = TransaksiOffline::with('pelanggan', 'details.menuMakanan')->findOrFail($id);
        return view('transaksi_offline.show', compact('transaksi_offline'));
    }

    public function destroy($id)
    {
        $trx = TransaksiOffline::findOrFail($id);
        $trx->delete();
        return redirect()->route('TransaksiOffline.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
