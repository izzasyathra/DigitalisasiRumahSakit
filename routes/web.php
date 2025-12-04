<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuestController; // (Asumsi ini Controller untuk halaman publik)
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Dokter\ScheduleController as DokterScheduleController; // Di-alias untuk menghindari konflik
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

// Halaman utama (Welcome Page)
Route::get('/', function () {
    // Anda dapat mengganti ini dengan tampilan publik yang sebenarnya
    return view('welcome'); 
});

// Halaman Layanan Publik (Dashboard Tamu)
Route::get('/public-services', [GuestController::class, 'index'])->name('guest.index');


Route::middleware(['auth', 'verified'])->group(function () {

    // --- DASHBOARD UMUM & PROFILE (Akses oleh semua peran) ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    
    // =========================================================
    // 2. ROUTE UNTUK ADMIN (Role: Admin)
    // =========================================================
    Route::middleware('role:Admin')->prefix('admin')->name('admin.')->group(function () {
        
        // Poli Management (CRUD)
        Route::resource('polis', PoliController::class)->except(['show']); // Ganti 'poli' menjadi 'polis'
        
        // User Management (List, Create, Edit Dokter dan Pasien)
        Route::resource('users', UserController::class); 

        // Verifikasi Janji Temu (Admin melihat SEMUA janji temu pending)
        Route::get('appointments/validation', [AppointmentController::class, 'adminValidationIndex'])->name('appointments.validation');
        Route::post('appointments/{appointment}/validate', [AppointmentController::class, 'adminValidate'])->name('appointments.validate');
    });


    // =========================================================
    // 3. ROUTE UNTUK DOKTER (Role: Dokter)
    // =========================================================
    Route::middleware('role:dokter')->prefix('dokter')->name('dokter.')->group(function () { // Gunakan casing 'dokter' kecil
        
        // Schedule Management (CRUD Jadwal Pribadi) - Menggunakan alias ScheduleController
        Route::resource('schedules', DokterScheduleController::class)->except(['show']); // Ganti 'schedule' menjadi 'schedules'
        
        // Medical Records Management (List, Create/Update Rekam Medis)
        Route::resource('medical-records', MedicalRecordController::class);

        // Validasi Janji Temu (Janji Temu yang ditujukan ke Dokter ini)
        Route::get('appointments/validation', [AppointmentController::class, 'validationIndex'])->name('appointments.validation');
        Route::post('appointments/{appointment}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');
        Route::post('appointments/{appointment}/reject', [AppointmentController::class, 'reject'])->name('appointments.reject');
    });


    // =========================================================
    // 4. ROUTE UNTUK PASIEN (Role: Pasien)
    // =========================================================
    Route::middleware('role:pasien')->prefix('pasien')->name('pasien.')->group(function () { // Gunakan casing 'pasien' kecil

        // Appointment Management (Membuat Janji Temu)
        Route::get('appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('appointments/my', [AppointmentController::class, 'myAppointments'])->name('appointments.my');
        
        // Medical Records Access (Melihat Rekam Medis Pribadi)
        Route::get('medical-records/my', [MedicalRecordController::class, 'myRecords'])->name('rm.my');
    });
});

require __DIR__.'/auth.php';