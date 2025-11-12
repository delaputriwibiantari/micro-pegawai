<?php

namespace App\Http\Requests\Ref;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RefBankRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_bank' => 'required|string|max:50',
            'kode_swift' => 'required|string|max:20',
            'customer_service' => 'required|string|max:20',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_bank' => 'Nama Bank',
            'kode_swift' => 'Kode Swift',
            'customer_service' => 'Customer Service',
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
            'nama_bank.required' => 'Field :attribute wajib diisi.',
            'nama_bank.string' => 'Field :attribute harus berupa teks.',
            'nama_bank.max' => 'Field :attribute maksimal :max karakter.',

            'kode_swift.required' => 'Field :attribute wajib diisi.',
            'kode_swift.string' => 'Field :attribute harus berupa teks.',
            'kode_swift.max' => 'Field :attribute maksimal :max karakter.',

            'customer_service.required' => 'Field :attribute wajib diisi.',
            'customer_service.string' => 'Field :attribute harus berupa teks.',
            'customer_service.max' => 'Field :attribute maksimal :max karakter.',
        ];

    }
}
