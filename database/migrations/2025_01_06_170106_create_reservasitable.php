<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id(); // ID utama
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users
            $table->string('nomor_telepon', 15); // Nomor telepon pelanggan
            $table->date('tanggal_reservasi'); // Tanggal reservasi
            $table->time('jam_reservasi'); // Jam reservasi
            $table->integer('jumlah_orang'); // Jumlah orang dalam reservasi

            // Relasi ke tabel meja
            $table->foreignId('meja_id')->constrained('meja')->onDelete('cascade');

            // Kolom baru: Snap token untuk Midtrans
            $table->string('snap_token')->nullable(); // Snap token bisa null jika belum ada pembayaran

            // Kolom baru: Status reservasi
            $table->enum('status', ['pending', 'paid', 'failed'])->default('Paid');

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
