<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MenuMakanan;
use App\Http\Requests\StoreMenuMakananRequest;
use App\Http\Requests\UpdateMenuMakananRequest;

use App\Charts\MenuMakananChart;

use Illuminate\Support\Facades\Storage;


class MenuMakananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MenuMakanan $menuMakanan)
    {
        $menu_makanan = MenuMakanan::all();
        return view('menu_makanan.index', compact('menu_makanan'));

    }

    // Method untuk customer
    public function customerView()
    {
        $dashboard = MenuMakanan::all();
        return view('menu_makanan.dashboardcustomer', compact('dashboard'));
    }

    public function showPahe()
    {
        $tampil_pahe = MenuMakanan::where('kategori', 'Paket Hemat')->get(); // atau sesuai field kategori Anda
        return view('menu_makanan.kategori.pahe', compact('tampil_pahe'));
    }

    public function showIndomie()
    {
        $tampil_indomie = MenuMakanan::where('kategori', 'Indomie')->get(); // atau sesuai field kategori Anda
        return view('menu_makanan.kategori.indomie', compact('tampil_indomie'));
    }

    public function showKornet()
    {
        $tampil_kornet = MenuMakanan::where('kategori', 'Kornet')->get(); // atau sesuai field kategori Anda
        return view('menu_makanan.kategori.kornet', compact('tampil_kornet'));
    }

    public function showNasi()
    {
        $tampil_nasi = MenuMakanan::where('kategori', 'Nasi')->get(); // atau sesuai field kategori Anda
        return view('menu_makanan.kategori.nasi', compact('tampil_nasi'));
    }

    public function showOmlet()
    {
        $tampil_omlet = MenuMakanan::where('kategori', 'Omlet')->get(); // atau sesuai field kategori Anda
        return view('menu_makanan.kategori.omlet', compact('tampil_omlet'));
    }

    public function showOrakarik()
    {
        $tampil_orakarik = MenuMakanan::where('kategori', 'Orak Arik')->get(); // atau sesuai field kategori Anda
        return view('menu_makanan.kategori.orakarik', compact('tampil_orakarik'));
    }

    public function showSarden()
    {
        $tampil_sarden = MenuMakanan::where('kategori', 'Sarden')->get(); // atau sesuai field kategori Anda
        return view('menu_makanan.kategori.sarden', compact('tampil_sarden'));
    }

    public function showTelur()
    {
        $tampil_telur = MenuMakanan::where('kategori', 'Telur')->get(); // atau sesuai field kategori Anda
        return view('menu_makanan.kategori.telur', compact('tampil_telur'));
    }

    public function showMinuman()
    {
        $tampil_minuman = MenuMakanan::where('kategori', 'Minuman Panas/Dingin')->get(); // atau sesuai field kategori Anda
        return view('menu_makanan.kategori.minuman', compact('tampil_minuman'));
    }

    public function showSearch(Request $request)
{
    $query = $request->input('q');
    $tampil_search = MenuMakanan::where('nama_menu', 'LIKE', '%' . $query . '%')->get();

    return view('menu_makanan.search', compact('tampil_search'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu_makanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|min:3|max:255',
            'deskripsi' => 'nullable',
            'stok' => 'nullable',
            'harga' => 'required|numeric',
            'kategori' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('menu_makanan', 'public');
        }

        MenuMakanan::create($validated);

        return redirect()->route('menu_makanan.index')->with('success', 'Menu berhasil ditambahkan');
    }

    

    /**
     * Display the specified resource.
     */
    public function show(MenuMakanan $menuMakanan)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuMakanan $menuMakanan)
    {
        return view('menu_makanan.edit', compact('menuMakanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuMakanan $menuMakanan)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|min:3|max:255',
            'deskripsi' => 'nullable',
            'stok' => 'nullable',
            'harga' => 'required|numeric',
            'kategori' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($menuMakanan->foto) {
                Storage::disk('public')->delete($menuMakanan->foto);
            }
            // Simpan foto baru
            $validated['foto'] = $request->file('foto')->store('menu_makanan', 'public');
        }

        $menuMakanan->update($validated);

        return redirect()->route('menu_makanan.index')->with('success', 'Menu berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $menuMakanan = MenuMakanan::findOrFail($id);

        if ($menuMakanan->foto) {
            Storage::disk('public')->delete($menuMakanan->foto);
        }

        $menuMakanan->delete();

        return redirect()->route('menu_makanan.index')->with('success', 'Data Berhasil di Hapus');
    }

}