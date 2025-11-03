<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HistoryRespon;
use App\Models\Post;
use App\Models\User;

class HistoryResponSeeder extends Seeder
{
    public function run(): void
    {
        $posts = Post::all();
        $users = User::where('role', 'user')->get();

        foreach ($posts as $post) {
            foreach ($users as $user) {
                HistoryRespon::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'response' => "Komentar dari {$user->username} pada post '{$post->excerpt}'.",
                    'likes_count' => rand(0, 5),
                ]);
            }
        }
    }
}
