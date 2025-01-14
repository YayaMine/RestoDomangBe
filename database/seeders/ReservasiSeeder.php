<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservasiSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        DB::table('reservasi')->insert([
            [
                'user_id' => 1, // ID user dari tabel users
                'nomor_telepon' => '081234567890', // Nomor telepon pelanggan
                'tanggal_reservasi' => Carbon::now()->addDays(1)->toDateString(), // Tanggal reservasi (besok)
                'jam_reservasi' => '12:30:00', // Jam reservasi
                'jumlah_orang' => 4, // Jumlah orang dalam reservasi
                'meja_id' => 1, // ID meja dari tabel meja
                'status' => 'pending', // Status reservasi (pending, paid, failed)
                'snap_token' => 'dummy-snap-token-1', // Snap token dummy
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2, // ID user lainnya
                'nomor_telepon' => '089876543210', // Nomor telepon pelanggan
                'tanggal_reservasi' => Carbon::now()->addDays(2)->toDateString(), // Tanggal reservasi (lusa)
                'jam_reservasi' => '18:00:00', // Jam reservasi
                'jumlah_orang' => 2, // Jumlah orang dalam reservasi
                'meja_id' => 2, // ID meja dari tabel meja
                'status' => 'paid', // Status reservasi (pending, paid, failed)
                'snap_token' => 'dummy-snap-token-2', // Snap token dummy
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);
    }
}