<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Membatasi akses halaman berdasarkan role pengguna.
     */
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->status !== 'aktif') {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Akun kamu tidak aktif. Hubungi administrator.',
                ]);
        }

        if (! in_array($user->role, $roles, true)) {
            abort(403, 'Kamu tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
