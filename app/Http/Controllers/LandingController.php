<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $explorations = Artwork::with('user', 'category')->latest()->limit(6)->get();

        return view('pages.landing', compact('explorations'));
    }
}
