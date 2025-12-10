<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    // READ: Menampilkan daftar Poli
    public function index()
    {
        $polis = Poli::orderBy('name')->get();
        return view('admin.poli.index', compact('polis'));
    }

    // CREATE: Menampilkan form tambah Poli
    public function create()
    {
        return view('admin.poli.create');
    }

    // CREATE: Menyimpan data Poli baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:polis,name',
            'description' => 'nullable',
            'icon_path' => 'nullable|string',
        ]);

        Poli::create($request->all());

        return redirect()->route('admin.poli.index')->with('success', 'Poli berhasil ditambahkan!');
    }

    // EDIT: Menampilkan form edit Poli
    public function edit(Poli $poli)
    {
        return view('admin.poli.edit', compact('poli'));
    }

    // UPDATE: Memperbarui data Poli
    public function update(Request $request, Poli $poli)
    {
        $request->validate([
            'name' => 'required|unique:polis,name,' . $poli->id,
            'description' => 'nullable',
            'icon_path' => 'nullable|string',
        ]);

        $poli->update($request->all());

        return redirect()->route('admin.poli.index')->with('success', 'Poli berhasil diperbarui!');
    }

    // DELETE: Menghapus Poli
    public function destroy(Poli $poli)
    {
        $poli->doctors()->update(['poli_id' => null]); 
        $poli->delete();

        return redirect()->route('admin.poli.index')->with('success', 'Poli berhasil dihapus.');
    }
}