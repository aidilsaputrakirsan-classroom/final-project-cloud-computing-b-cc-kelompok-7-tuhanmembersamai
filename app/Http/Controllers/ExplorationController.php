<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Comment;
use App\Models\Like;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExplorationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artworks = Artwork::with('user', 'category')->select('id', 'image', 'description', 'user_id')->where('category_id', 1)->get();

        return view('pages.exploration', compact('artworks'));
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
        $category = $request->input('category');
        $artworks = Artwork::with('user', 'category')
            ->whereHas('category', function ($query) use ($category) {
                $query->where('name', $category);
            })
            ->select('id', 'image', 'description', 'user_id')
            ->get();
        return response()->json($artworks);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Artwork::with('user', 'category')->findOrFail($id);
        $likes = Like::where('artwork_id', $id)->count();
        $comments = Comment::with('user', 'artwork')->where('artwork_id', $id)->get();
        $comment_count = Comment::where('artwork_id', $id)->count();

        $isLiked = Like::where('user_id', Auth::id())->where('artwork_id', $id)->first();
        if ($isLiked) {
            $isLiked = true;
        } else {
            $isLiked = false;
        }

        return view('pages.detail-exploration', compact('data', 'likes', 'comments', 'comment_count', 'isLiked'));
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
        //
    }

    public function like(string $id)
    {
        $auth = Auth::check();
        if (!$auth) {
            return response()->json(['message' => 'silakan login terlebih dahulu']);
        }
        $user_id = Auth::id();

        $like = Like::where('user_id', $user_id)->where('artwork_id', $id)->first();

        if ($like) {
            $like->delete();
            $like_count = Like::where('artwork_id', $id)->count();
            return response()->json(['message' => 'unlike', 'count' => $like_count]);
        } else {
            Like::create([
                'user_id' => $user_id,
                'artwork_id' => $id,
            ]);
            $like_count = Like::where('artwork_id', $id)->count();
            return response()->json(['message' => 'like', 'count' => $like_count]);
        }
    }

    public function comment(Request $request, string $id)
    {
        $request->validate([
            'message' => 'required|string'
        ]);
        try {
            $auth = Auth::check();
            if (!$auth) {
                return redirect()->route('login');
            }
            $user_id = Auth::id();

            Comment::create([
                'user_id' => $user_id,
                'artwork_id' => $id,
                'message' => $request->input('message'),
            ]);

            return redirect()->back()->with('success', 'Comment has been sent');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to comment');
        }
    }
}
