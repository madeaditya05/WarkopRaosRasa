<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawan = Karyawan::all();
        return view('karyawan.index', compact('karyawan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            
            'nama' => 'required|min:3|max:255',
            'jabatan' => 'required',
            'email' => 'required|email|unique:karyawan',
            'telepon' => 'nullable',
            
        ]);

        Karyawan::create($validated);
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            
            'nama' => 'required|min:3|max:255',
            'jabatan' => 'required',
            'email' => 'required|email',
            'telepon' => 'nullable',
            
        ]);

        $karyawan->update($validated);
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus');
    }
}
