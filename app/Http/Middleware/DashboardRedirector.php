<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DashboardRedirector
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah pengguna sudah login
        if (Auth::check()) {
            $user = Auth::user();

            // 2. Logika Pengalihan (Wajib Sesuai Nama Route)
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'dokter') {
                // Asumsi dokter.dashboard dan route-nya sudah dibuat
                return redirect()->route('doctor.dashboard');
            } elseif ($user->role === 'pasien') {
                // Masalah utama: Jika route ini tidak ditemukan, sistem crash/gagal.
                return redirect()->route('patient.dashboard');
            }
        }
        
        // Lanjutkan ke halaman yang diminta (misalnya, homepage guest)
        return $next($request);
    }
}