<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AdminBaseController extends Controller
{
    public function __construct(Request $request)
    {
        // CEK HANYA SAAT LOAD HALAMAN (BUKAN AJAX)
        if (!$request->ajax()) {

            if (!$request->has('admin')) {
                abort(403, 'Parameter admin tidak ditemukan');
            }

            try {
                $adminId = Crypt::decryptString($request->query('admin'));
            } catch (\Exception $e) {
                abort(403, 'Parameter admin tidak valid');
            }

            if ((string) $adminId !== (string) Auth::guard('admin')->id()) {
                abort(403, 'Akses terlarang');
            }
        }
    }
}
