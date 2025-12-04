<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poli;
use App\Models\User;
// Asumsikan Anda sudah membuat Model Poli

class GuestController extends Controller
{
    // Menampilkan daftar Poli dan konten Guest lainnya
    public function index()
    {
        // Ambil daftar Poli dari database (misalnya, yang statusnya aktif)
        // Jika Anda belum memiliki Model/Tabel Poli, Anda bisa menggunakan data dummy dulu.
        try {
            $polis = Poli::all();
        } catch (\Exception $e) {
            // Jika tabel Poli belum dibuat, gunakan data dummy sementara
            $polis = [
                (object)['nama_poli' => 'Poli Umum', 'deskripsi' => 'Layanan kesehatan umum.', 'ikon' => '🩺'],
                (object)['nama_poli' => 'Poli Gigi', 'deskripsi' => 'Spesialis perawatan gigi.', 'ikon' => '🦷'],
                (object)['nama_poli' => 'Poli Anak', 'deskripsi' => 'Kesehatan dan tumbuh kembang anak.', 'ikon' => '🧸'],
                (object)['nama_poli' => 'Poli Mata', 'deskripsi' => 'Pemeriksaan mata dan visus.', 'ikon' => '👓'],
            ];
        }

        return view('guest.index', compact('polis'));
    }
    
    // Anda bisa menambahkan fungsi lain seperti showDoctorsByPoli(Poli $poli) di sini
}