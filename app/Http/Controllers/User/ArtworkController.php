<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SupabaseStorageService;

class ArtworkController extends Controller
{
    protected $supabaseStorageService;

    public function __construct()
    {
        $this->supabaseStorageService = new SupabaseStorageService();
    }

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

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'description' => 'required|string',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:5048',
        ]);

        try {
            // file untuk Supabase
            $file = $request->file('image');
            $filename = uniqid() . '_' . $file->getClientOriginalName();

            // upload ke Supabase
            $publicUrl = $this->supabaseStorageService->upload($file, $filename);

            // simpan ke DB
            Artwork::create([
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'description' => $request->description,
                'image' => $publicUrl,  // URL Supabase
            ]);

            return redirect()->route('profile.index')
                ->with('success', 'Artwork berhasil ditambahkan!');

        } catch (Exception $e) {
            return redirect()->route('profile.index')
                ->with('error', 'Artwork gagal ditambahkan! ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $artwork = Artwork::findOrFail($id);

            // Tidak menghapus dari Supabase (jika mau, nanti saya buatkan)
            $artwork->delete();

            return redirect()->route('profile.index')->with('success', 'Artwork berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->route('profile.index')->with('error', 'Artwork gagal dihapus!');
        }
    }
}
