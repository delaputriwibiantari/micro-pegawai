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

    /* =====================
     | KODE ASLI KAMU (UTUH)
     ===================== */

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
        $decaySeconds = 300;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return redirect()->back()
                ->with('error', $this->lockoutMessage($seconds))
                ->with('lock_seconds', $seconds);
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|email',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::guard('admin')->attempt([
            'email' => $username,
            'password' => $password
        ])) {

            session()->regenerate();

            session([
                'id' => Auth::guard('admin')->id(),
                'role' => Auth::guard('admin')->user()->role,
                'email' => Auth::guard('admin')->user()->email,
                'name' => Auth::guard('admin')->user()->name,
                'login_time' => now(),
            ]);

            RateLimiter::clear($key);

            // ⛔ TETAP SEPERTI ASLI
            return redirect()->intended();
        }

        RateLimiter::hit($key, $decaySeconds);
        return redirect()->back()->with('error', 'Login gagal');
    }

    private function throttleKey(string $username, string $ip): string
    {
        return 'login|' . sha1($username . '|' . $ip);
    }

    private function lockoutMessage(int $seconds): string
    {
        return "Akun dikunci {$seconds} detik";
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('admin')->logout();
        session()->flush();
        return redirect()->route('index');
    }

    public function error(Request $request): JsonResponse
    {
        if ($request->header('X-CSRF-TOKEN') !== csrf_token()) {
            return $this->responseService->errorResponse('CSRF invalid');
        }

        Log::channel('daily')->error('client-error', ['data' => $request->all()]);
        return $this->responseService->successResponse('Logged');
    }

    public function viewFile(Request $request, string $dir, string $filename): BinaryFileResponse|StreamedResponse
    {
        return $this->fileUploadService->viewFile($request, $dir, $filename);
    }

    public function resetpassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'new_password' => [
                'required','confirmed',
                Password::min(10)->letters()->mixedCase()->numbers()->symbols()
            ],
        ]);

        $user = Admin::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$user) {
            return response()->json(['message'=>'user tidak ditemukan'], 404);
        }

        $user->password = bcrypt($request->new_password);
        $user->otp = null;
        $user->save();

        return response()->json(['message'=>'Password update success']);
    }

    /* =====================
     | 🔐 TAMBAHAN KEAMANAN
     | TANPA UBAH LOGIN
     ===================== */

    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            abort(403);
        }

        $token = encrypt([
            'admin_id' => $admin->id,
            'exp' => now()->addMinutes(30),
        ]);

        return redirect()->route('admin.dashboard.secure', $token);
    }

    public function dashboardSecure(string $token): View
    {
        try {
            $payload = decrypt($token);
        } catch (\Throwable $e) {
            abort(403);
        }

        if (
            $payload['admin_id'] !== Auth::guard('admin')->id() ||
            now()->greaterThan($payload['exp'])
        ) {
            abort(403);
        }

        return view('admin.dashboard');
    }
}
