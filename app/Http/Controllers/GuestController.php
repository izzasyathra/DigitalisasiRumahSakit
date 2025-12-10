<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poli;
use App\Models\User;

class GuestController extends Controller
{
    // Menampilkan daftar Poli dan konten Guest lainnya
    public function index()
    {
        
        try {
            $polis = Poli::all();
        } catch (\Exception $e) {
            $polis = [
                (object)['nama_poli' => 'Poli Umum', 'deskripsi' => 'Layanan kesehatan umum.', 'ikon' => '🩺'],
                (object)['nama_poli' => 'Poli Gigi', 'deskripsi' => 'Spesialis perawatan gigi.', 'ikon' => '🦷'],
                (object)['nama_poli' => 'Poli Anak', 'deskripsi' => 'Kesehatan dan tumbuh kembang anak.', 'ikon' => '🧸'],
                (object)['nama_poli' => 'Poli Mata', 'deskripsi' => 'Pemeriksaan mata dan visus.', 'ikon' => '👓'],
            ];
        }

        return view('guest.index', compact('polis'));
    }
    
}