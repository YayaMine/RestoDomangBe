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
        Schema::create('meja', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedInteger('jumlah_orang'); // Kapasitas meja
            $table->string('nomor_meja')->unique(); // Nomor meja
            $table->enum('letak_meja', ['Indoor', 'Outdoor']); // Lokasi meja
            $table->decimal('harga_meja', 10, 2)->default(0); // Harga meja

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meja');
    }
};