<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Teknologi', 'description' => 'Artikel tentang perkembangan teknologi.'],
            ['name' => 'Bisnis', 'description' => 'Tips dan berita bisnis terkini.'],
            ['name' => 'Kesehatan', 'description' => 'Informasi seputar kesehatan dan gaya hidup.'],
            ['name' => 'Edukasi', 'description' => 'Materi dan artikel pendidikan.'],
            ['name' => 'Lingkungan', 'description' => 'Isu dan solusi lingkungan hidup.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
