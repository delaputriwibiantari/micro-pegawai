<?php

namespace App\Http\Requests\Ref;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RefJenisDokumenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenis_dokumen' => 'required|string|max:20',
        ];
    }

    public function attributes(): array
    {
        return [
            'jenis_dokumen' => 'Jenis Dokumen',
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
            'jenis_dokumen.required' => 'Field :attribute wajib diisi.',
            'jenis_dokumen.string' => 'Field :attribute harus berupa teks.',
            'jenis_dokumen.max' => 'Field :attribute maksimal :max karakter.',
        ];
    }
}
