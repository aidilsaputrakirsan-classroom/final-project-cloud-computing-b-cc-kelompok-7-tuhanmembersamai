<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'admin')->first();
        $categories = Category::all();

        foreach ($categories as $index => $category) {
            Post::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'excerpt' => "Ringkasan singkat artikel ke-" . ($index + 1),
                'content' => "Ini adalah isi lengkap artikel ke-" . ($index + 1) . ". Berisi informasi menarik seputar " . $category->name . ".",
                'featured_image' => "images/posts/post" . ($index + 1) . ".jpg",
                'status' => 'published',
            ]);
        }
    }
}
