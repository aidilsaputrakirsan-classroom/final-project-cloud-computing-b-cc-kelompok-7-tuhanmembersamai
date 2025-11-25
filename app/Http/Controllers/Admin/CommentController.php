<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function destroy(Comment $comment)
    {
        // Log activity
        addLog(Auth::id(), 'admin_delete_comment', 'Admin menghapus komentar dari user ' . $comment->user->name);

        $comment->delete();

        return back()->with('success', 'Komentar dihapus.');
    }
}
