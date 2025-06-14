<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles  // PASTIKAN BAGIAN INI BENAR
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Loop melalui semua role yang diizinkan untuk rute ini
        foreach ($roles as $role) {
            // Periksa apakah role pengguna cocok dengan salah satu role yang diizinkan
            if ($user->role === $role) {
                return $next($request); // Izinkan akses jika cocok
            }
        }

        // Jika tidak ada role yang cocok, alihkan atau tolak akses
        // Anda bisa mengalihkan ke dashboard dengan pesan error, atau menampilkan halaman 403
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses untuk halaman ini.');
    }
}