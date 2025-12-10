<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Janji Temu (Wajib)
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('restrict'); 
            
            // Relasi ke Dokter dan Pasien (untuk memudahkan query)
            $table->foreignId('doctor_id')->constrained('users')->onDelete('restrict'); 
            $table->foreignId('patient_id')->constrained('users')->onDelete('restrict');
            
            $table->date('tanggal_berobat'); // Tanggal konsultasi (sama dengan tanggal_booking)
            $table->text('diagnosis');
            $table->text('tindakan')->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};