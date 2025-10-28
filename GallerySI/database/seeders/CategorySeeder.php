<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['Digital Art', 'Poster', 'Web Design', 'Wallpaper', 'Kerajinan Tangan', 'Ilustrasi', 'Portofolio', 'Typography', 'PowerPoint', 'Animasi', 'Tanah Liat'];
        foreach ($names as $name) {
            DB::table('categories')->insert([
                'name' => $name,
                'created_at' => now(),
            ]);
        }
    }
}
