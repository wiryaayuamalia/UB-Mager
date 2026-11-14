<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekRole
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = $request->user();
        if (!$user || !in_array($user->role, $roles)) {
            abort(403, 'Anda tidak punya akses ke halaman ini.');
        }
        if ($user->status_akun !== 'aktif') {
            abort(403, 'Akun Anda tidak aktif / disuspend.');
        }
        return $next($request);
    }
}
