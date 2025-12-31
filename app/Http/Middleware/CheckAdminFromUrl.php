<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CheckAdminFromUrl
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('admin')) {
            abort(403, 'Parameter admin tidak ditemukan');
        }

        try {
            $adminIdFromUrl = Crypt::decryptString($request->query('admin'));
        } catch (\Exception $e) {
            abort(403, 'Parameter admin tidak valid');
        }

        if ((string) $adminIdFromUrl !== (string) Auth::guard('admin')->id()) {
            abort(403, 'Akses terlarang');
        }

        return $next($request);
    }
}
