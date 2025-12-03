<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard sesuai dengan peran (role) pengguna yang login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        // Mendapatkan objek pengguna yang sedang login
        $user = Auth::user();

        // Pengecekan role pengguna
        if ($user->role === 'Admin') {
            // Dashboard Admin: Menampilkan ringkasan sistem, janji temu pending, dll.
            return view('dashboard.admin');
        } 
        
        elseif ($user->role === 'Dokter') {
            // Dashboard Dokter: Menampilkan janji temu yang perlu divalidasi dan antrean konsultasi hari ini.
            return view('dashboard.dokter');
        } 
        
        elseif ($user->role === 'Pasien') {
            // Dashboard Pasien: Menampilkan status janji temu terakhir, notifikasi resep, dll.
            return view('dashboard.pasien');
        } 
        
        else {
            // Role tidak dikenal atau role default
            // Anda bisa mengarahkan ke halaman home/welcome jika role tidak terdaftar
            return redirect('/');
        }
    }
}