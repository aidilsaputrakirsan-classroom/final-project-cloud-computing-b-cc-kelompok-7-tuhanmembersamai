<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function destroy(Comment $comment)
    {
        $postId = $comment->post_id;
        $comment->delete();

        return redirect()
            ->route('admin.posts.show', $postId)
            ->with('success', 'Komentar dihapus.');
    }
}
