<?php

namespace App\Http\Requests\Ref;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RefJenisAsuransiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_asuransi' => 'required|string|max:100',
            'nama_asuransi' => 'required|string|max:100',
            'penyelenggara' => 'required|string|max:100',
            'tipe_asuransi' => 'required|string|max:100',
        ];
    }

    public function attributes(): array
    {
        return [
            'kode_asuransi' => 'Kode Asuransi',
            'nama_asuransi' => 'Nama Asuransi',
            'penyelenggara' => 'Penyelenggara',
            'tipe_asuransi' => 'Tipe Asuransi',

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
            'kode_asuransi.required' => 'Field :attribute wajib diisi.',
            'kode_asuransi.string' => 'Field :attribute harus berupa teks.',
            'kode_asuransi.max' => 'Field :attribute maksimal :max karakter.',

            'nama_asuransi.required' => 'Field :attribute wajib diisi.',
            'nama_asuransi.string' => 'Field :attribute harus berupa teks.',
            'nama_asuransi.max' => 'Field :attribute maksimal :max karakter.',

            'penyelenggara.required' => 'Field :attribute wajib diisi.',
            'penyelenggara.string' => 'Field :attribute harus berupa teks.',
            'penyelenggara.max' => 'Field :attribute maksimal :max karakter.',

            'tipe_asuransi.required' => 'Field :attribute wajib diisi.',
            'tipe_asuransi.string' => 'Field :attribute harus berupa teks.',
            'tipe_asuransi.max' => 'Field :attribute maksimal :max karakter.',
        ];

    }
}
