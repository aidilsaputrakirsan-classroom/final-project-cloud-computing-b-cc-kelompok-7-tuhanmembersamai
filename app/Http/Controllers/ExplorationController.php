<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
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
        $categories = Category::all();
        $artworks = Artwork::with('user', 'category')
            ->select('id', 'image', 'description', 'user_id', 'category_id')
            ->where('category_id', $categories->first()?->id ?? 1)
            ->get();

        // Notifikasi
        $notif = 0;
        if (Auth::check()) {
            $userArtworks = Artwork::where('user_id', Auth::id())->pluck('id');

            $notif = Like::whereIn('artwork_id', $userArtworks)->count()
                    + Comment::whereIn('artwork_id', $userArtworks)->count();
        }

        return view('pages.exploration', compact('artworks', 'notif', 'categories'));
    }

    public function store(Request $request)
    {
        $category = $request->input('category');
        $artworks = Artwork::with('user', 'category')
            ->whereHas('category', function ($query) use ($category) {
                $query->where('name', $category);
            })
            ->select('id', 'image', 'description', 'user_id')
            ->get();

        $payload = $artworks->map(function ($a) {
            return [
                'id' => $a->id,
                'image' => $a->image,
                'description' => $a->description,
                'user' => [
                    'name' => $a->user ? $a->user->name : null,
                    'image' => $a->user ? $a->user->image : null,
                ],
            ];
        });

        return response()->json($payload);
    }

    public function search(Request $request)
    {
        $query = (string) $request->input('query', '');

        if (trim($query) === '') {
            return response()->json([]);
        }

        $artworks = Artwork::with('user')
            ->whereHas('category', function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->orWhere('description', 'like', '%' . $query . '%')
            ->select('id', 'image', 'description', 'user_id')
            ->get();

        $payload = $artworks->map(function ($a) {
            return [
                'id' => $a->id,
                'image' => $a->image,
                'description' => $a->description,
                'user' => [
                    'name' => $a->user ? $a->user->name : null,
                    'image' => $a->user ? $a->user->image : null,
                ],
            ];
        });

        return response()->json($payload);
    }

    public function show(string $id)
    {
        $data = Artwork::with('user', 'category')->findOrFail($id);
        $likes = Like::where('artwork_id', $id)->count();
        $comments = Comment::with('user', 'artwork')->where('artwork_id', $id)->get();
        $comment_count = Comment::where('artwork_id', $id)->count();

        $isLiked = Like::where('user_id', Auth::id())->where('artwork_id', $id)->exists();

        // Notifikasi
        $notif = 0;
        if (Auth::check()) {
            $userArtworks = Artwork::where('user_id', Auth::id())->pluck('id');

            $notif = Like::whereIn('artwork_id', $userArtworks)->count()
                    + Comment::whereIn('artwork_id', $userArtworks)->count();
        }

        return view('pages.detail-exploration', compact(
            'data',
            'likes',
            'comments',
            'comment_count',
            'isLiked',
            'notif'
        ));
    }

        public function notifications()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userArtworks = Artwork::where('user_id', Auth::id())->pluck('id');

        $likeNotif = Like::with('user', 'artwork')
            ->whereIn('artwork_id', $userArtworks)
            ->orderBy('created_at', 'desc')
            ->get();

        $commentNotif = Comment::with('user', 'artwork')
            ->whereIn('artwork_id', $userArtworks)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.notifications', compact('likeNotif', 'commentNotif'));
    }
    public function like(string $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'silakan login terlebih dahulu']);
        }

        $user_id = Auth::id();

        $like = Like::where('user_id', $user_id)->where('artwork_id', $id)->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => $user_id,
                'artwork_id' => $id,
            ]);
        }

        $like_count = Like::where('artwork_id', $id)->count();

        return response()->json([
            'count' => $like_count
        ]);
    }

    public function comment(Request $request, string $id)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        Comment::create([
            'user_id' => Auth::id(),
            'artwork_id' => $id,
            'message' => $request->input('message'),
        ]);

        return redirect()->back()->with('success', 'Comment has been sent');
    }
}
