<?php

namespace App\Http\Requests\absensi;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class JadwalKerjaRequest extends FormRequest
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
            'jadwal_id' => 'nullable|string|max:10',
            'nama' => 'required|string|max:50',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
        ];
    }

    public function attributes(): array
    {
        return [
            'jadwal_id' => 'ID Jadwal',
            'nama' => 'Nama Jadwal',
            'jam_mulai' => 'Jam Mulai',
            'jam_selesai' => 'Jam Selesai'
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

            'nama.required' => 'Field :attribute wajib diisi.',
            'nama.string' => 'Field :attribute harus berupa teks.',
            'nama.max' => 'Field :attribute maksimal :max karakter.',

            'jam_mulai.required' => 'Field :attribute wajib diisi.',
            'jam_mulai.date_format' => 'Field :attribute harus berupa waktu dengan format HH:MM.',

            'jam_selesai.required' => 'Field :attribute wajib diisi.',
            'jam_selesai.date_format' => 'Field :attribute harus berupa waktu dengan format HH:MM.',

        ];
    }
}
