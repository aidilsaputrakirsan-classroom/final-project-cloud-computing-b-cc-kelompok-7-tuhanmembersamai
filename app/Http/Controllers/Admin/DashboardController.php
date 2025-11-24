<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Artwork; // atau Post?
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
return view('pages.admin.dashboard', [
    'total_users' => User::count(),
    'total_categories' => Category::count(),
    'total_posts' => Artwork::count(),
    'latest_posts' => Artwork::latest()->take(5)->get()
]);

    }
}
