<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'avatar' => 'https://ui-avatars.com/api/?name=Admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'faris',
                'email' => 'faris@example.com',
                'password' => Hash::make('faris123'),
                'role' => 'user',
                'avatar' => 'https://ui-avatars.com/api/?name=Faris',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'razzan',
                'email' => 'razzan@example.com',
                'password' => Hash::make('razzan123'),
                'role' => 'user',
                'avatar' => 'https://ui-avatars.com/api/?name=Razzan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
