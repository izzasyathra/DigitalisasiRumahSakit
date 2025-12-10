<?php
namespace App\Http\Controllers\Guest;
use App\Http\Controllers\Controller;
use App\Models\Poli;

class PoliController extends Controller
{
    public function index()
    {
        // Pastikan nama kolom benar ('name' bukan 'nama_poli')
        $polis = Poli::orderBy('name', 'asc')->get();
        return view('guest.poli', compact('polis'));
    }
}