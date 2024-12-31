<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin', // Set role sebagai admin
        ]);

        User::create([
            'name' => 'Member User',
            'email' => 'member@example.com',
            'password' => bcrypt('password'),
            'role' => 'member', // Set role sebagai member
        ]);
    }
}