<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.admin.users', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Log activity
        addLog(Auth::id(), 'admin_delete_user', 'Admin menghapus user: ' . $user->name . ' (' . $user->email . ')');

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.');
    }
}
