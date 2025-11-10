<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // list & view-link
    public function index()
    {
        $posts = Post::with(['user','category'])
            ->latest()
            ->paginate(10);

        return view('pages.admin.posts.index', compact('posts'));
    }

    // detail + comments
    public function show(Post $post)
    {
        $post->load(['user','category','comments.user']);
        return view('pages.admin.posts.show', compact('post'));
    }

    // form edit
    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        return view('pages.admin.posts.edit', compact('post','categories'));
    }

    // update data
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'category_id' => ['nullable','exists:categories,id'],
            'image'       => ['required','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $post->update($validated);

        return redirect()
            ->route('admin.posts.show', $post)
            ->with('success', 'Post berhasil diperbarui.');
    }

    // hapus post (otomatis hapus comments jika FK cascade)
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post telah dihapus.');
    }
}
