<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBahanBakuRequest;
use App\Http\Requests\UpdateBahanBakuRequest;
use Illuminate\Support\Facades\DB;

class BahanBakuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bahanbaku = BahanBaku::all();
        return view('bahanbaku.index', compact('bahanbaku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bahanbaku.create',
        [
            'kode_bahan' => BahanBaku::getKodeBahanBaku()
        ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_bahan' => 'required',
            'nama_bahan' => 'required|max:100',
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|max:20',
            'harga_per_satuan' => 'required|numeric',
        ]);

        BahanBaku::create($validated);
        return redirect()->route('bahanbaku.index')->with('success', 'BahanBaku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(BahanBaku $bahanBaku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BahanBaku $bahanbaku)
{
    return view('bahanbaku.edit', compact('bahanbaku'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BahanBaku $bahanbaku)
    {
        $validated = $request->validate([
            'kode_bahan' => 'required',
            'nama_bahan' => 'required|max:100',
            'jumlah' => 'required',
            'satuan' => 'required',
            'harga_per_satuan' => 'required',
        ]);

        $bahanbaku->update($validated);
        return redirect()->route('bahanbaku.index')->with('success', 'BahanBaku berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bahanbaku = BahanBaku::findOrFail($id);
        $bahanbaku->delete();

        return redirect()->route('bahanbaku.index')->with('success', 'BahanBaku berhasil dihapus');
    }
}
