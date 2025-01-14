<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('meja')->insert([
            [
                'jumlah_orang' => 2,
                'nomor_meja' => 'M001',
                'letak_meja' => 'Indoor',
                'harga_meja' => 50000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'jumlah_orang' => 4,
                'nomor_meja' => 'M002',
                'letak_meja' => 'Outdoor',
                'harga_meja' => 75000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'jumlah_orang' => 6,
                'nomor_meja' => 'M003',
                'letak_meja' => 'Indoor',
                'harga_meja' => 100000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'jumlah_orang' => 4,
                'nomor_meja' => 'M004',
                'letak_meja' => 'Outdoor',
                'harga_meja' => 85000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
