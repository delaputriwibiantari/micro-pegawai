<?php

namespace App\Http\Requests\absensi;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class JenisAbsensiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jenis_absen_id' => 'nullable|string|max:10',
            'nama_absen' => 'required|string|max:50',
            'kategori' => 'required|string|max:50',
            'potong_gaji' => 'required|boolean',
            'warna' => 'required|string|max:7',
        ];
    }

    public function attributes(): array
    {
        return [
            'jenis_absen_id' => 'ID Jenis Absen',
            'nama_absen' => 'Nama Absen',
            'kategori' => 'Kategori',
            'potong_gaji' => 'Potong Gaji',
            'warna' => 'Warna',
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
            'nama_absen.required' => 'Field :attribute wajib diisi.',
            'nama_absen.string' => 'Field :attribute harus berupa teks.',
            'nama_absen.max' => 'Field :attribute maksimal :max karakter.',

            'kategori.required' => 'Field :attribute wajib diisi.',
            'kategori.string' => 'Field :attribute harus berupa teks.',
            'kategori.max' => 'Field :attribute maksimal :max karakter.',

            'potong_gaji.required' => 'Field :attribute wajib diisi.',
            'potong_gaji.boolean' => 'Field :attribute harus berupa boolean.',

            'warna.required' => 'Field :attribute wajib diisi.',
            'warna.string' => 'Field :attribute harus berupa teks.',
        ];
    }
}
