<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('polis', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Wajib 'name' agar cocok dengan Seeder & Controller
$table->text('description')->nullable(); // Pastikan deskripsi juga bahasa inggris kalau bisa
$table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('polis');
    }
};