<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Category;
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
            // Simpan file gambar ke storage/app/public/artwork
            $path = $request->file('image')->store('artworks', 'public');

            Artwork::create([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'description' => $request->description,
                'image' => $path, // simpan path lengkap, contoh: artwork/abcd123.jpg
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

            // Hapus file gambar dari Supabase
            if ($artwork->image && Storage::disk('supabase')->exists($artwork->image)) {
                Storage::disk('supabase')->delete($artwork->image);
            }

            // Hapus record database
            $artwork->delete();

            return redirect()->route('profile.index')->with('success', 'Artwork berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->route('profile.index')->with('error', 'Artwork gagal dihapus!');
        }
    }
}
