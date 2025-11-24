<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Category;
use App\Models\Like;
use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::id();
        $artworks = Artwork::with(['user', 'category'])
            ->where('user_id', $user_id)
            ->select('id', 'image', 'description', 'category_id')
            ->get();

        // Add like and comment counts untuk setiap artwork
        $artworks = $artworks->map(function($artwork) {
            $artwork->likes_count = Like::where('artwork_id', $artwork->id)->count();
            $artwork->comments_count = Comment::where('artwork_id', $artwork->id)->count();
            return $artwork;
        });

        $categories = Category::select('id', 'name')->get();
        $profile = Auth::user();

        return view('pages.profile', compact('artworks', 'categories', 'profile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'description' => 'required|string',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:5048',
        ]);


        try {
            // gunakan disk sesuai konfigurasi env FILESYSTEM_DISK (default 'public' untuk dev)
            $disk = env('FILESYSTEM_DISK', 'public');

            // Simpan file gambar ke disk (mis: public atau s3)
            $path = $request->file('image')->store('artworks', $disk);

            Artwork::create([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'description' => $request->description,
                'image' => $path, // simpan path lengkap, contoh: artworks/abcd123.jpg
            ]);

            return redirect()->route('profile.index')->with('success', 'Artwork berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->route('profile.index')->with('error', 'Artwork gagal ditambahkan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $artwork = Artwork::findOrFail($id);

            // Hapus file gambar dari storage
            $disk = env('FILESYSTEM_DISK', 'public');
            if ($artwork->image && Storage::disk($disk)->exists($artwork->image)) {
                Storage::disk($disk)->delete($artwork->image);
            }

            // Hapus record dari database
            $artwork->delete();

            return redirect()->route('profile.index')->with('success', 'Artwork berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->route('profile.index')->with('error', 'Artwork gagal dihapus!');
        }
    }
}
