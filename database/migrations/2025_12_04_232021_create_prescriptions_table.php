<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke Rekam Medis (Wajib)
            $table->foreignId('medical_record_id')->constrained('medical_records')->onDelete('cascade'); 
            
            // Relasi ke Obat (Medicine Management)
            $table->foreignId('medicine_id')->constrained('medicines')->onDelete('restrict'); 
            
            $table->unsignedInteger('jumlah'); // Jumlah obat yang diresepkan
            $table->text('aturan_minum')->nullable(); // Misal: 3x sehari setelah makan
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};