<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole 
{
    /**
     * Handle an incoming request.
     * * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  Peran yang diizinkan (e.g., 'Admin', 'Dokter', 'Pasien').
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // 2. Cek apakah peran pengguna sesuai dengan peran yang diminta di route
        if ($user->role !== $role) {
            
            
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isDoctor()) {
                return redirect()->route('doctor.dashboard');
            } elseif ($user->isPatient()) {
                return redirect()->route('patient.dashboard');
            }
            
            return redirect('/login')->withErrors('Akses ditolak. Peran pengguna tidak valid.');
        }

        // 3. Jika peran sesuai, lanjutkan request ke controller
        return $next($request);
    }
}