<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $profile = Auth::user();

        return view('pages.edit-profile', compact('profile'));
    }

    public function update(Request $request)
    {
        try {
            $user_id = Auth::id();
            $profile = User::findOrFail($user_id);

            $data = $request->all();

            if ($request->has('email') && $request->email != $profile->email) {
                $request->validate([
                    'email' => 'unique:users,email'
                ]);
            }

            $profile->update($data);

            return redirect()->route('profile.index')->with('success', 'Profile berhasil diupdate!!');
        } catch (Exception $e) {
            return redirect()->route('profile.index')->with('error', 'Profile Gagal diupdate!!');
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user_id = Auth::id();
            $profile = User::findOrFail($user_id);

            $data = $request->all();

            if (isset($profile->image)) {
                unlink("storage/user/" . $profile->image);
            }

            $image = $request->file('image');
            $image->storeAs('public/user', $image->hashName());

            $data['image'] = $image->hashName();

            $profile->update($data);

            return redirect()->route('profile.index')->with('success', 'Photo Profile berhasil diupdate!!');
        } catch (Exception $e) {
            return redirect()->route('profile.index')->with('error', 'Photo Profile Gagal diupdate!!');
        }
    }
}
