<?php

namespace App\Http\Controllers\content;

use App\Http\Controllers\Controller;
use App\Models\App\Admin;
use App\Services\Tools\FileUploadService;
use App\Services\Tools\ResponseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PortalController extends Controller
{
    public function __construct(
        private readonly ResponseService $responseService,
        private readonly FileUploadService $fileUploadService
    ){}

    public function login(): View
    {
        if (Auth::guard('admin')->check()) {
            return view('admin.dashboard');
        }
        return view('portal');
    }

    public function logindb(Request $request): RedirectResponse
    {
        $username = strtolower($request->input('username'));
        $password = $request->input('password');
        $ip = $request->ip();
        $key = $this->throttleKey($username, $ip);
        $maxAttempts = 5;
        $decaySeconds = 300; // 5 menit

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            $message = $this->lockoutMessage($seconds);
            return redirect()
                ->back()
                ->with('error', $message)
                ->with('lock_seconds', $seconds); // 👈 kirim sisa waktu ke view
        }

        $validationRules = [
            'username' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ];

        $customMessages = [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
            'g-recaptcha-response.required' => 'Silakan centang captcha terlebih dahulu',
            'g-recaptcha-response.captcha' => 'Verifikasi captcha gagal, coba lagi.',
        ];

        $validator = Validator::make($request->all(), $validationRules, $customMessages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::guard('admin')->attempt(['email' => $username, 'password' => $password])) {
            RateLimiter::clear($key); // reset hitungan gagal
            return redirect()->intended();
        }

        RateLimiter::hit($key, $decaySeconds);

        $remainingAttempts = $maxAttempts - RateLimiter::attempts($key);
        $remainingAttempts = max(0, $remainingAttempts);

        return redirect()
            ->back()
            ->withInput()
            ->with('error', "Nama pengguna atau kata sandi salah. Tersisa {$remainingAttempts} percobaan sebelum akun dikunci.");
    }

    private function throttleKey(string $username, string $ip): string
    {
        return 'login|' . sha1($username . '|' . $ip);
    }

    /**
     * Format pesan kunci akun
     */
    private function lockoutMessage(int $seconds): string
    {
        $minutes = intdiv($seconds, 60);
        $secs = $seconds % 60;

        $parts = [];
        if ($minutes > 0) $parts[] = "{$minutes} menit";
        if ($secs > 0) $parts[] = "{$secs} detik";

        return 'Akun dikunci karena terlalu banyak percobaan login. Coba lagi dalam ' . implode(' ', $parts) . '.';
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();

        return redirect()->route('index')->with('success', 'Anda telah berhasil keluar.');
    }

    public function error(Request $request): JsonResponse
    {
        $csrfToken = $request->header('X-CSRF-TOKEN');

        if ($csrfToken !== csrf_token()) {
            return $this->responseService->errorResponse('Token CSRF tidak valid.');
        }

        Log::channel('daily')->error('client-error', ['data' => $request->all()]);

        return $this->responseService->successResponse('Error berhasil dicatat.');
    }

    public function viewFile(Request $request, string $dir, string $filename): BinaryFileResponse|StreamedResponse
    {
        return $this->fileUploadService->viewFile($request, $dir, $filename);
    }

    public function resetpassword(Request $request){
        $request->validate([
        'email' => 'required|string|email',
        'otp' => 'required|string',
        'new_password' => [
            'required',
            'confirmed',
            Password::min(10)
                ->max(64)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),
        ],
    ], [
        'new_password.required' => 'Kata sandi baru wajib diisi.',
        'new_password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
    ]);

        $user = Admin::where('email', $request->email)->where('otp',
        $request->otp)->first();
        if (!$user){
            return response()->json([
                'message'=> 'user tidak ditemukan'
            ], 404);
        }

        $user->password = bcrypt($request->new_password);
        $user->otp = NULL;

        if($user->save()) {
            return response()->json([
                'message' => 'Password update success'
            ], 200);
        }else{
            return response()->json([
                'message'=>'ada eror'
            ],500);
        }
    }
}
