<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel users.
     */
    public function run(): void
    {
        // Pastikan user admin ada, kalau belum maka buat.
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // kondisi unik
            [
                'name' => 'Admin',
                'password' => Hash::make('admin'), // password terenkripsi
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
