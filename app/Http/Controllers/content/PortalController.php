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
       $username = $request->input('username');
       $password = $request->input('password');
       

       $validationRules =[
           'username' => 'required',
           'password' => 'required'
       ];

       $customMessages =[
           'username.required' => 'Username wajib diisi',
           'password.required' => 'Password wajib diisi'
       ];

       $validator = Validator::make($request->all(), $validationRules, $customMessages);

       if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::guard('admin')->attempt(['email' => $username, 'password' => $password])) {
            return redirect()->intended();
        } else {
            return redirect()->back()->with('error', 'nama pengguna dan kata kunci salah');
        }
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
