<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::id();
        $artworks = Artwork::select('id', 'image', 'description', 'category_id')->with('user', 'category')->where('user_id', $user_id)->get();
        $categories = Category::select('id', 'name')->get();
        $profile = Auth::user();

        return view('pages.profile', compact('artworks', 'categories', 'profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'description' => 'required|string',
            'image' => 'required|mimes:png,jpg,jpeg|max:5048'
        ]);
        try {
            $data = $request->all();

            $image = $request->file('image');
            $image->storeAs('public/artwork', $image->hashName());

            $data['image'] = $image->hashName();
            $data['user_id'] = auth()->id();

            Artwork::create($data);

            return redirect()->route('profile.index')->with('success', 'Artwork berhasil ditambahkan!!');
        } catch (Exception $e) {
            return redirect()->route('profile.index')->with('error', 'Artwork Gagal ditambahkan!!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $artwork = Artwork::with(['user', 'category'])->findOrFail($id);

            if (isset($artwork->image)) {
                unlink("storage/artwork/" . $artwork->image);
            }

            $artwork->delete();

            return redirect()->route('profile.index')->with('success', 'Artwork berhasil dihapus!!');
        } catch (Exception $e) {
            return redirect()->route('profile.index')->with('error', 'Artwork Gagal dihapus!!');
        }
    }
}
