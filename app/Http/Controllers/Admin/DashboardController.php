<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Artwork;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function __construct()
    {
        // proteksi ganda; route-group sudah memakai middleware auth + is.admin
        $this->middleware(['auth', 'is.admin']);
    }

    public function index()
    {
        try {
            // optional caching (seconds), ubah/disable sesuai kebutuhan
            $total_users = Cache::remember('dashboard_total_users', 30, fn () => User::count());
            $total_categories = Cache::remember('dashboard_total_categories', 30, fn () => Category::count());
            $total_posts = Cache::remember('dashboard_total_posts', 30, fn () => Artwork::count());
            $total_activity_logs = Cache::remember('dashboard_total_activity_logs', 30, fn () => ActivityLog::count());

            // ambil posts terbaru (pastikan Artwork->category relasi ada)
            $latest_posts = Artwork::with('category')->latest()->take(5)->get();

            // ambil activity logs terbaru, eager-load user (ambil field minimal)
            $latest_activity_logs = ActivityLog::with('user:id,name,image')->latest()->take(10)->get();

            return view('pages.admin.dashboard', [
                'total_users' => $total_users,
                'total_categories' => $total_categories,
                'total_posts' => $total_posts,
                'total_activity_logs' => $total_activity_logs,
                'latest_posts' => $latest_posts,
                'latest_activity_logs' => $latest_activity_logs,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error rendering admin dashboard: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            // Tampilkan view kosong + pesan error supaya tidak terjadi redirect loop
            return view('pages.admin.dashboard', [
                'total_users' => 0,
                'total_categories' => 0,
                'total_posts' => 0,
                'total_activity_logs' => 0,
                'latest_posts' => collect(),
                'latest_activity_logs' => collect(),
            ])->with('error', 'Terjadi kesalahan saat memuat dashboard. Cek log.');
        }
    }
}
