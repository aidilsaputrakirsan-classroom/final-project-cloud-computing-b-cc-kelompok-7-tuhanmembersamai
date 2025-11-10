<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    protected $supabaseUrl;
    protected $supabaseKey;

    public function __construct()
    {
        $this->supabaseUrl = env('SUPABASE_URL');
        $this->supabaseKey = env('SUPABASE_SERVICE_ROLE_KEY');
    }

    // === Tampilkan semua kategori ===
    public function index()
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . '/rest/v1/categories?select=*');

        $categories = $response->json() ?? [];

        return view('pages.admin.categories.index', compact('categories'));
    }

    // === Form Tambah Kategori ===
    public function create()
    {
        return view('pages.admin.categories.create');
    }

    // === Simpan Data Kategori ===
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ])->post($this->supabaseUrl . '/rest/v1/categories', [
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // === Detail Kategori ===
    public function show($id)
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . "/rest/v1/categories?id=eq.$id");

        $category = $response->json()[0] ?? null;

        if (!$category) {
            abort(404, 'Kategori tidak ditemukan');
        }

        return view('pages.admin.categories.show', compact('category'));
    }

    // === Form Edit Kategori ===
    public function edit($id)
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->get($this->supabaseUrl . "/rest/v1/categories?id=eq.$id");

        $category = $response->json()[0] ?? null;

        if (!$category) {
            abort(404, 'Kategori tidak ditemukan');
        }

        return view('pages.admin.categories.edit', compact('category'));
    }

    // === Update Data Kategori ===
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json'
        ])->patch($this->supabaseUrl . "/rest/v1/categories?id=eq.$id", [
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // === Hapus Kategori ===
    public function destroy($id)
    {
        Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->delete($this->supabaseUrl . "/rest/v1/categories?id=eq.$id");

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}