<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('title'); // Judul Laporan
        $table->text('description'); // Deskripsi
        $table->date('incident_date'); // Tanggal Kejadian
        $table->string('location'); // Lokasi
        $table->string('image_path')->nullable(); // Unggah Gambar
        // Enum status sesuai request: diajukan, diterima, ditolak, selesai
        $table->enum('status', ['diajukan', 'diterima', 'ditolak', 'selesai'])->default('diajukan');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
