<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // List
    public function index()
    {
        $posts = Artwork::with(['user','category'])
            ->latest()
            ->paginate(10);

        return view('pages.admin.posts.index', compact('posts'));
    }

    // Detail + comments
    public function show(Artwork $artwork)
    {
        // eager-load comments + user
        $artwork->load(['user','category','comments.user']);

        // agar di blade variabelnya tetap $post
        $post = $artwork;
        return view('pages.admin.posts.show', compact('post'));
    }

    // Form edit
    public function edit(Artwork $artwork)
    {
        $categories = Category::orderBy('name')->get();
        $post = $artwork;
        return view('pages.admin.posts.edit', compact('post','categories'));
    }

    // Update
    public function update(Request $request, Artwork $artwork)
    {
        $validated = $request->validate([
            'category_id' => ['required','integer','exists:categories,id'],
            'description' => ['nullable','string'],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        // upload image bila ada
        if ($request->hasFile('image')) {
            // simpan ke storage/app/public/artworks
            $path = $request->file('image')->store('artworks', 'public');
            $validated['image'] = $path;

            // hapus file lama kalau ada
            if ($artwork->image && Storage::disk('public')->exists($artwork->image)) {
                Storage::disk('public')->delete($artwork->image);
            }
        }

        $artwork->update($validated);

        return redirect()
            ->route('admin.posts.show', $artwork)
            ->with('success', 'Post berhasil diupdate.');
    }

    // Delete post
    public function destroy(Artwork $artwork)
    {
        // hapus file image kalau ada
        if ($artwork->image && Storage::disk('public')->exists($artwork->image)) {
            Storage::disk('public')->delete($artwork->image);
        }

        // hapus child comments
        $artwork->comments()->delete();

        $artwork->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post berhasil dihapus.');
    }
}
