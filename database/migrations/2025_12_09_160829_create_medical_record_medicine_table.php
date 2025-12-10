<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('medical_record_medicine', function (Blueprint $table) {
        $table->id();
        
        // Relasi ke tabel medical_records
        $table->foreignId('medical_record_id')
              ->constrained('medical_records')
              ->onDelete('cascade');
              
        // Relasi ke tabel medicines
        $table->foreignId('medicine_id')
              ->constrained('medicines')
              ->onDelete('cascade');
              
        // Kolom jumlah obat
        $table->integer('quantity');
        
        $table->timestamps();
    });
}
};
