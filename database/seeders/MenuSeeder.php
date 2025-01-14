<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            [
                'nama_menu' => 'Nasi Goreng Spesial',
                'kategori_menu' => 'makanan', // Konsisten dengan enum kategori_menu
                'harga_menu' => 25000,
                'deskripsi' => 'Nasi goreng dengan bumbu spesial dan tambahan ayam suwir serta telur.',
                'foto_menu' => 'images/nasi_goreng_spesial.jpg', // Path relatif ke folder public
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'Es Teh Manis',
                'kategori_menu' => 'minuman', // Konsisten dengan enum kategori_menu
                'harga_menu' => 5000,
                'deskripsi' => 'Teh manis segar yang disajikan dengan es batu.',
                'foto_menu' => 'images/es_teh_manis.jpg', // Path relatif ke folder public
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'Paket Ayam Geprek',
                'kategori_menu' => 'paket', // Konsisten dengan enum kategori_menu
                'harga_menu' => 35000,
                'deskripsi' => 'Paket ayam geprek lengkap dengan nasi, sambal, dan lalapan.',
                'foto_menu' => 'images/paket_ayam_geprek.jpg', // Path relatif ke folder public
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'Jus Alpukat',
                'kategori_menu' => 'minuman', // Konsisten dengan enum kategori_menu
                'harga_menu' => 15000,
                'deskripsi' => 'Jus alpukat segar dengan tambahan susu kental manis.',
                'foto_menu' => 'images/jus_alpukat.jpg', // Path relatif ke folder public
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_menu' => 'Sate Ayam',
                'kategori_menu' => 'makanan', // Konsisten dengan enum kategori_menu
                'harga_menu' => 30000,
                'deskripsi' => 'Sate ayam dengan bumbu kacang khas Indonesia.',
                'foto_menu' => 'images/sate_ayam.jpg', // Path relatif ke folder public
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
