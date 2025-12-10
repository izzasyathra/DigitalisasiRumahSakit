<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// --- Controller Auth ---
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;

// --- Controller Guest (Tamu) ---
use App\Http\Controllers\Guest\PoliController;
use App\Http\Controllers\Guest\DoctorController as GuestDoctorController;
use App\Http\Controllers\Guest\ScheduleController as GuestScheduleController;

// --- Controller Admin ---
// PENTING: Kita gunakan DoctorController dari namespace Admin untuk fitur Edit Dokter yang baru
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController; 
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\PoliController as AdminPoliController;
use App\Http\Controllers\Admin\MedicineController as AdminMedicineController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\ValidationController;

// --- Controller Pasien ---
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;

// --- Controller Dokter (Role) ---
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Doctor\MedicalRecordController;
use App\Http\Controllers\Doctor\ScheduleController as DoctorScheduleController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Doctor\ConsultationController;

// --- Controller Shared (Validasi) ---
use App\Http\Controllers\Validation\AppointmentValidationController;

// ====================================================================
// --- A. RUTE GUEST (PUBLIK) ---
// ====================================================================

// Halaman Depan
Route::get('/', function () {
    return view('guest.home');
})->name('guest.home');

// 1. Daftar Poli
Route::get('/poli', [PoliController::class, 'index'])->name('guest.poli.index');

// 2. Daftar Dokter
Route::get('/dokter', [GuestDoctorController::class, 'index'])->name('guest.doctor.index');

// 3. Jadwal Praktik
Route::get('/jadwal', [GuestScheduleController::class, 'index'])->name('guest.schedules.index');

// Auth (Login/Register)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::post('/register', [AuthController::class, 'register']);

// ====================================================================
// --- B. RUTE ADMIN (Role: admin) ---
// ====================================================================

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // 1. Dashboard Admin
    Route::get('/dashboard', function () {
        $pendingCount = DB::table('appointments')->where('status', 'Pending')->count();
        $doctorsCount = DB::table('users')->where('role', 'dokter')->count();
        $usersCount = DB::table('users')->where('role', 'pasien')->count();

        return view('admin.dashboard', compact('pendingCount', 'doctorsCount', 'usersCount'));
    })->name('dashboard');

    // 2. Validasi Janji Temu (Admin View)
    Route::get('/validation', [ValidationController::class, 'index'])->name('validation.index');
    Route::post('/validation/{id}', [ValidationController::class, 'updateStatus'])->name('validation.update');

    // 3. Resource Controllers (CRUD Data Master)
    Route::resource('users', AdminUserController::class);
    Route::resource('poli', AdminPoliController::class);
    Route::resource('medicines', AdminMedicineController::class);
    Route::resource('schedules', AdminScheduleController::class);

    // 4. Manajemen Akun Dokter (MENGGUNAKAN CONTROLLER BARU)
    // Ini mengarah ke App\Http\Controllers\Admin\DoctorController
    Route::resource('doctors', AdminDoctorController::class); 
});


// ====================================================================
// --- C. RUTE PASIEN (Role: pasien) ---
// ====================================================================

Route::middleware(['auth', 'role:pasien'])
    ->prefix('patient')
    ->name('patient.')
    ->group(function () {

    // 1. Dashboard Pasien (History Janji Temu)
    Route::get('/dashboard', [PatientAppointmentController::class, 'index'])->name('dashboard');

    // 2. Buat Janji Temu (Halaman Form)
    Route::get('/appointments/create', [PatientAppointmentController::class, 'create'])->name('appointments.create');

    // 3. Proses Simpan Janji Temu
    Route::post('/appointments', [PatientAppointmentController::class, 'store'])->name('appointments.store');

    // 4. Detail Janji Temu & Hasil Rekam Medis
    Route::get('/appointments/{id}', [PatientAppointmentController::class, 'show'])->name('appointments.show');

    // 5. AJAX Ambil Dokter berdasarkan Poli
    Route::get('/get-doctors/{poliId}', [PatientAppointmentController::class, 'getDoctorsByPoli'])->name('get-doctors');
});


// ====================================================================
// --- D. RUTE DOKTER (Role: dokter) ---
// ====================================================================

Route::middleware(['auth', 'role:dokter'])->prefix('doctor')->name('doctor.')->group(function () {

    // 1. Dashboard Dokter
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');

    // 2. Manajemen Jadwal Praktik
    Route::resource('schedules', DoctorScheduleController::class);

    // 3. Validasi Janji Temu (Daftar Pending)
    Route::get('/appointments', [DoctorAppointmentController::class, 'index'])->name('appointments.index');
    Route::put('/appointments/{id}/approve', [DoctorAppointmentController::class, 'approve'])->name('appointments.approve');
    Route::put('/appointments/{id}/reject', [DoctorAppointmentController::class, 'reject'])->name('appointments.reject');

    // 4. Proses Konsultasi (Periksa Pasien)
    Route::get('/consultation', [ConsultationController::class, 'index'])->name('consultation.index');
    Route::get('/consultation/{appointment}', [ConsultationController::class, 'create'])->name('consultation.create'); // Form Periksa
    Route::post('/consultation/{appointment}', [ConsultationController::class, 'store'])->name('consultation.store'); // Simpan Rekam Medis
});


// ====================================================================
// --- E. RUTE VALIDASI (Shared Admin/Dokter - Opsional) ---
// ====================================================================

Route::middleware(['auth', 'role:admin|dokter'])->prefix('validation')->name('validation.')->group(function () {
    Route::get('/', [AppointmentValidationController::class, 'index'])->name('index');
    Route::put('/{appointment}', [AppointmentValidationController::class, 'update'])->name('update');
});