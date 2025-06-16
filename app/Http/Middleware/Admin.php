<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Kalau user adalah admin, lanjut akses route
        if ($user->usertype == 'admin') {
            return $next($request);
        }

        // Kalau user siswa, redirect ke dashboard siswa
        if ($user->usertype == 'siswa') {
            return redirect()->route('siswa.dashboard');
        }

        // Kalau user ptk, redirect ke dashboard ptk
        if ($user->usertype == 'ptk') {
            return redirect()->route('ptk.dashboard');
        }

        // Jika role tidak dikenal, logout dan redirect ke login
        Auth::logout();
        return redirect()->route('login');
    }
}
