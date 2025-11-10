<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Ambil like pada karya milik user
        $likes = Like::with('user', 'artwork')
            ->whereHas('artwork', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->latest()
            ->get();

        // Ambil komentar pada karya milik user
        $comments = Comment::with('user', 'artwork')
            ->whereHas('artwork', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->latest()
            ->get();

        return view('pages.notifications', compact('likes', 'comments'));
    }
}
