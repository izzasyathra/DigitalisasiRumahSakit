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
                return redirect()->route('doctor.dashboard');
            } elseif ($user->role === 'pasien') {
                return redirect()->route('patient.dashboard');
            }
        }
        
        return $next($request);
    }
}