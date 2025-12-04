// routes/web.php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentValidationController;

// --- 1. Route Publik (Guest) ---
Route::get('/', [DashboardController::class, 'publicIndex'])->name('home');
Route::get('/polis', [PoliController::class, 'indexPublic'])->name('polis.public');
Route::get('/doctors', [UserController::class, 'doctorsPublic'])->name('doctors.public');

// --- 2. Route Autentikasi ---
Auth::routes(); // Mengurus /login dan /register (Pasien)

// --- 3. Route Terproteksi (Semua User yang Login) ---
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management (Semua bisa mengedit profil)
    Route::resource('profile', ProfileController::class)->only(['edit', 'update']);

    // --- A. Pasien Routes ---
    Route::prefix('patient')->middleware(['role:Pasien'])->group(function () {
        Route::get('appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('appointments/my', [AppointmentController::class, 'myAppointments'])->name('appointments.my');
        
        // Route yang bertindak sebagai API (via AJAX), harus ada di web.php
        Route::get('schedules/available', [AppointmentController::class, 'getAvailableSchedules'])->name('schedules.available');
        
        // Akses Rekam Medis Pribadi
        Route::get('medical-records/my', [MedicalRecordController::class, 'myRecords'])->name('records.my');
    });

    // --- B. Dokter Routes ---
    Route::prefix('doctor')->middleware(['role:Dokter'])->group(function () {
        Route::resource('schedules', ScheduleController::class); // Schedule Management
        Route::get('appointments/validation', [AppointmentValidationController::class, 'index'])->name('appointments.doctor_validate');
        Route::put('appointments/{appointment}/status', [AppointmentValidationController::class, 'updateStatus'])->name('appointments.update_status');
        Route::resource('medical-records', MedicalRecordController::class); // Rekam Medis Management
    });

    // --- C. Admin Routes ---
    Route::prefix('admin')->middleware(['role:Admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('polis', PoliController::class);
        Route::resource('medicines', MedicineController::class);
        Route::get('appointments/all', [AppointmentValidationController::class, 'indexAll'])->name('appointments.admin_all');
        // Route untuk Laporan, dll.
    });
});