<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\BahanBaku;
use App\Models\TransaksiPembelianBahanBaku;
use App\Models\DetailTransaksiPembelianBahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianBahanBakuController extends Controller
{
    public function create()
    {
        $suppliers = Supplier::all();
        $bahanBakus = BahanBaku::all(); // untuk autocomplete nama bahan, satuan & harga
        return view('pembelianbahanbaku.create', compact('suppliers', 'bahanBakus'));
    }

    public function store(Request $request)
{
    $request->validate([
        'supplier_id' => 'required|exists:supplier,id',
        'tanggal' => 'required|date',
        'items' => 'required|array|min:1',
        'items.*.nama_bahan' => 'required|string',
        'items.*.jumlah' => 'required|numeric|min:1',
        'items.*.satuan' => 'nullable|string',
        'items.*.harga_satuan' => 'nullable|numeric|min:0',
    ]);

    DB::beginTransaction();

    try {
        $transaksi = TransaksiPembelianBahanBaku::create([
            'supplier_id' => $request->supplier_id,
            'tanggal' => $request->tanggal,
            'subtotal' => 0,
        ]);

        $totalSubtotal = 0;
        $processedBahan = [];

        foreach ($request->items as $item) {
            $namaBahan = trim($item['nama_bahan']);
            $jumlah = (float) $item['jumlah'];
            $hargaSatuanInput = isset($item['harga_satuan']) ? (float) $item['harga_satuan'] : 0;
            $satuanInput = $item['satuan'] ?? 'unit';

            // Cek apakah bahan sudah ada
            $bahan = BahanBaku::whereRaw('LOWER(nama_bahan) = ?', [strtolower($namaBahan)])->first();

            if (!$bahan) {
                // Buat bahan baru
                $kodeBahan = $this->generateKodeBahan();
                $bahan = BahanBaku::create([
                    'kode_bahan' => $kodeBahan,
                    'nama_bahan' => $namaBahan,
                    'jumlah' => $jumlah,
                    'satuan' => $satuanInput,
                    'harga_per_satuan' => $hargaSatuanInput,
                ]);
            } else {
                // Update stok bahan lama
                $bahan->jumlah += $jumlah;
                $bahan->harga_per_satuan = $hargaSatuanInput > 0 ? $hargaSatuanInput : $bahan->harga_per_satuan;
                $bahan->save();
            }

            $hargaSatuan = $bahan->harga_per_satuan;

            // Tambahkan ke detail transaksi
            if (isset($processedBahan[$bahan->id])) {
                $detail = DetailTransaksiPembelianBahanBaku::find($processedBahan[$bahan->id]);
                $detail->jumlah += $jumlah;
                $detail->subtotal = $detail->jumlah * $hargaSatuan;
                $detail->save();
            } else {
                $detail = DetailTransaksiPembelianBahanBaku::create([
                    'transaksi_id' => $transaksi->id,
                    'bahan_baku_id' => $bahan->id,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $hargaSatuan,
                    'subtotal' => $jumlah * $hargaSatuan,
                ]);
                $processedBahan[$bahan->id] = $detail->id;
            }

            $totalSubtotal += $jumlah * $hargaSatuan;
        }

        // Update total subtotal transaksi
        $transaksi->subtotal = $totalSubtotal;
        $transaksi->save();

        DB::commit();

        return redirect()->route('bahanbaku.index')->with('success', 'Transaksi berhasil disimpan dan stok bahan diperbarui.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors('Terjadi kesalahan: ' . $e->getMessage())->withInput();
    }
}


    // Fungsi untuk generate kode bahan otomatis (contoh: DD-005, DD-006, dst)
    private function generateKodeBahan()
    {
        $latest = BahanBaku::orderBy('id', 'desc')->first();
        $nextNumber = $latest ? ((int) filter_var($latest->kode_bahan, FILTER_SANITIZE_NUMBER_INT)) + 1 : 1;
        return 'DD-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}