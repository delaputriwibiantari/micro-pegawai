<?php

namespace App\Http\Requests\Master;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class MasterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'nama' => [
                'required',
                'string',
                'min:4',
                'max:20',
                'regex:/^[A-Za-z](?!.*__)[A-Za-z0-9_]{3,19}$/',
                Rule::unique('admin', 'nama')->ignore($id)->where(function ($query) {
                    // unik case-insensitive
                    return $query->whereRaw('LOWER(nama) = LOWER(?)', [$this->nama]);
                }),
            ],
                'email' => [
                'required',
                'email',
                'string',
                'max:254',

                // Validasi dari aturan kamu (no double dot + domain valid + karakter aman)
                'regex:/^(?!.*\.\.)[A-Za-z0-9._%+\-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',

                // Validasi domain khusus user (gmail.com / yahoo.com)
                'regex:/@(gmail\.com|yahoo\.com)$/i',

                // Unique tapi abaikan user saat edit
                Rule::unique('admin', 'email')->ignore($id),
            ],
            'password' => [
                $this->routeIs('admin.master.user.store') ? 'required' : 'nullable',
                'string',
                'min:10',
                'max:64',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d\s])([^\s]*)$/',
                function ($attribute, $value, $fail) {
                    $common = [
                        'password', 'password123', 'qwerty', 'welcome',
                        'admin123', '12345678', 'password123!', 'qwerty2024!', 'welcome1!'
                    ];
                    if (in_array($value, $common)) {
                        $fail('Password terlalu umum atau mudah ditebak.');
                    }
                },
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Role',
            'otp' => 'OTP',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->messages(),
            ], 422)
        );
    }

    public function messages(): array
    {
        return [
            // --- Username (name) ---
            'nama.required' => 'Username wajib diisi.',
            'nama.string' => 'Username harus berupa teks.',
            'nama.min' => 'Username minimal harus terdiri dari :min karakter.',
            'nama.max' => 'Username maksimal hanya boleh :max karakter.',
            'nama.regex' => 'Username harus diawali huruf, hanya boleh huruf/angka/underscore, dan tidak boleh mengandung dua underscore berurutan (__).',
            'nama.unique' => 'Username sudah digunakan, silakan pilih yang lain.',

            // --- Email ---
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.string' => 'Email harus berupa teks.',
            'email.max' => 'Email tidak boleh lebih dari 254 karakter.',
            'email.regex' => 'Format email salah. Gunakan format yang benar dan domain harus gmail.com atau yahoo.com.',
            'email.unique' => 'Email sudah digunakan.',


            // --- Password ---
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal harus terdiri dari :min karakter.',
            'password.max' => 'Password maksimal hanya boleh :max karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, simbol, dan tidak boleh mengandung spasi.',
        ];
    }

}
