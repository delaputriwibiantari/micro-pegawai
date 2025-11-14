<?php

namespace App\Http\Controllers\content;

use App\Http\Controllers\Controller;
use App\Mail\OTP;
use App\Models\App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Helpers\Tools; // ✅ tambahkan ini di atas

class AuthController extends Controller
{
    public function send(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $user = Admin::where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Email tidak ditemukan',
        ], 404);
    }

    $otp = $this->generateSecureOTP();

    // 🟢 Ubah bagian ini:
    Mail::to($request->email)->send(new \App\Mail\OTP($otp, $request->email));

    $data = [
        'otp' => $otp
    ];

    $user->update($data);

    return response()->json([
        'success' => true,
        'message' => 'Kode OTP sudah dikirim',
    ]);
}


    public function verifikasi(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = Admin::where('otp', $request->otp)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'OTP tidak cocok atau sudah tidak berlaku',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi OTP berhasil',
            'data' => $user
        ]);
    }

    private function generateSecureOTP(int $length = 6): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        return implode('', array_map(
            fn() => $characters[random_int(0, $charactersLength - 1)],
            range(1, $length)
        ));
    }
}
