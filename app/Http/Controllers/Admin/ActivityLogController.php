<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter berdasarkan user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter berdasarkan action
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Filter berdasarkan tanggal
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(15);

        // Ambil list user untuk dropdown
        $users = \App\Models\User::select('id', 'name')->orderBy('name')->get();

        // Ambil unique actions untuk dropdown
        $actions = ActivityLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        return view('pages.admin.activity-logs.index', compact('logs', 'users', 'actions'));
    }

    /**
     * Display the specified activity log.
     */
    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user');
        return view('pages.admin.activity-logs.show', compact('activityLog'));
    }
}
