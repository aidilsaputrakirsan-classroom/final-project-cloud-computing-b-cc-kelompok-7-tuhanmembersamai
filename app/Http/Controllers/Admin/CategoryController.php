<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

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
        $options = [];
        if (!app()->environment('production')) {
            $options['verify'] = false; // Disable SSL verification for local dev
        }

        try {
            $response = Http::withOptions($options)->withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
            ])->get($this->supabaseUrl . '/rest/v1/categories?select=*');

            $categories = $response->ok() ? $response->json() : [];
        } catch (\Exception $e) {
            logger()->error('Supabase categories fetch failed: ' . $e->getMessage());
            $categories = [];
        }

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

        $options = [];
        if (!app()->environment('production')) {
            $options['verify'] = false;
        }

        try {
            $response = Http::withOptions($options)->withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => 'application/json',
                'Prefer' => 'return=representation'
            ])->post($this->supabaseUrl . '/rest/v1/categories', [
                'name' => $request->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (!$response->successful()) {
                logger()->error('Supabase category store failed: ' . $response->body());
                return redirect()->route('admin.categories.index')->with('error', 'Gagal menambahkan kategori.');
            }
        } catch (\Exception $e) {
            logger()->error('Supabase category store exception: ' . $e->getMessage());
            return redirect()->route('admin.categories.index')->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }

        // Log activity
        addLog(Auth::id(), 'admin_create_category', 'Admin membuat kategori baru: ' . $request->name);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // === Detail Kategori ===
    public function show($id)
    {
        $options = [];
        if (!app()->environment('production')) {
            $options['verify'] = false;
        }

        try {
            $response = Http::withOptions($options)->withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
            ])->get($this->supabaseUrl . "/rest/v1/categories?id=eq.$id");

            if (!$response->ok()) {
                logger()->error('Supabase category show failed: ' . $response->body());
                abort(404, 'Kategori tidak ditemukan');
            }

            $category = $response->json()[0] ?? null;

            if (!$category) {
                abort(404, 'Kategori tidak ditemukan');
            }
        } catch (\Exception $e) {
            logger()->error('Supabase category show exception: ' . $e->getMessage());
            abort(500, 'Gagal mengambil data kategori: ' . $e->getMessage());
        }

        return view('pages.admin.categories.show', compact('category'));
    }

    // === Form Edit Kategori ===
    public function edit($id)
    {
        $options = [];
        if (!app()->environment('production')) {
            $options['verify'] = false;
        }

        try {
            $response = Http::withOptions($options)->withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
            ])->get($this->supabaseUrl . "/rest/v1/categories?id=eq.$id");

            if (!$response->ok()) {
                logger()->error('Supabase category edit failed: ' . $response->body());
                abort(404, 'Kategori tidak ditemukan');
            }

            $category = $response->json()[0] ?? null;

            if (!$category) {
                abort(404, 'Kategori tidak ditemukan');
            }
        } catch (\Exception $e) {
            logger()->error('Supabase category edit exception: ' . $e->getMessage());
            abort(500, 'Gagal mengambil data kategori: ' . $e->getMessage());
        }

        return view('pages.admin.categories.edit', compact('category'));
    }

    // === Update Data Kategori ===
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $options = [];
        if (!app()->environment('production')) {
            $options['verify'] = false;
        }

        try {
            $response = Http::withOptions($options)->withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Content-Type' => 'application/json'
            ])->patch($this->supabaseUrl . "/rest/v1/categories?id=eq.$id", [
                'name' => $request->name,
                'updated_at' => now(),
            ]);

            if (!$response->successful()) {
                logger()->error('Supabase category update failed: ' . $response->body());
                return redirect()->route('admin.categories.index')->with('error', 'Gagal memperbarui kategori.');
            }
        } catch (\Exception $e) {
            logger()->error('Supabase category update exception: ' . $e->getMessage());
            return redirect()->route('admin.categories.index')->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }

        // Log activity
        addLog(Auth::id(), 'admin_update_category', 'Admin update kategori: ' . $request->name);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // === Hapus Kategori ===
    public function destroy($id)
    {
        $options = [];
        if (!app()->environment('production')) {
            $options['verify'] = false;
        }

        try {
            $response = Http::withOptions($options)->withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
            ])->delete($this->supabaseUrl . "/rest/v1/categories?id=eq.$id");

            if (!$response->successful()) {
                logger()->error('Supabase category destroy failed: ' . $response->body());
                return redirect()->route('admin.categories.index')->with('error', 'Gagal menghapus kategori.');
            }
        } catch (\Exception $e) {
            logger()->error('Supabase category destroy exception: ' . $e->getMessage());
            return redirect()->route('admin.categories.index')->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }

        // Log activity
        addLog(Auth::id(), 'admin_delete_category', 'Admin menghapus kategori dengan ID: ' . $id);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
