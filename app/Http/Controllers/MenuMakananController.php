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