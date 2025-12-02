<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (! $user || ($user->role ?? '') !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }
            return redirect('/')->with('error', 'Akses admin diperlukan.');
        }
        return $next($request);
    }
}
