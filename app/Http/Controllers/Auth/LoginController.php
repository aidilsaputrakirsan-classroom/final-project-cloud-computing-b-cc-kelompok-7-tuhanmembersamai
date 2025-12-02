<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Default redirect for non-admin users (not used by our custom login but kept).
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override default login to support "login as admin" checkbox logic.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
            'as_admin' => 'nullable|boolean',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $asAdmin = (bool) $request->input('as_admin', false);

        // Find user by email
        $user = User::where('email', $email)->first();

        // If no user or password mismatch -> invalid credentials
        if (! $user || ! Hash::check($password, $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        // If trying to login AS ADMIN, ensure user role is admin
        if ($asAdmin) {
            if (($user->role ?? '') !== 'admin') {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => 'Akun ini tidak memiliki akses admin.']);
            }
            // proceed login as admin
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();
            addLog($user->id, 'login', 'Admin login ke sistem');
            return redirect()->intended(route('admin.dashboard'));
        }

        // Not admin login: log in as regular user (even if role = admin)
        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();
        addLog($user->id, 'login', 'User login ke sistem');

        // redirect to exploration (homepage)
        return redirect()->intended(route('exploration'));
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $userId = Auth::id();
        if ($userId) {
            addLog($userId, 'logout', 'User logout dari sistem');
        }

        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // After logout, go to login page
        return redirect('/login');
    }

    /**
     * Keep the trait's authenticated method as fallback (not used by our login override).
     * Left empty or minimal.
     */
    protected function authenticated(Request $request, $user)
    {
        // no-op: handled by custom login()
    }
}
