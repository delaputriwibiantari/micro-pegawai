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
            'nama_jadwal' => 'required|string|max:50',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i',
            'jam_batas_masuk' => 'required|date_format:H:i',
            'jam_batas_pulang' => 'required|date_format:H:i',
            'toleransi_terlambat' => 'required|integer|min:0|max:32767',
        ];
    }

    public function attributes(): array
    {
        return [
            'jadwal_id' => 'ID Jadwal',
            'nama_jadwal' => 'Nama Jadwal',
            'jam_masuk' => 'Jam Masuk',
            'jam_pulang' => 'Jam Pulang',
            'jam_batas_masuk' => 'Jam Batas Masuk',
            'jam_batas_pulang' => 'Jam Batas Pulang',
            'toleransi_terlambat' => 'Toleransi Terlambat',
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

            'nama_jadwal.required' => 'Field :attribute wajib diisi.',
            'nama_jadwal.string' => 'Field :attribute harus berupa teks.',
            'nama_jadwal.max' => 'Field :attribute maksimal :max karakter.',

            'jam_masuk.required' => 'Field :attribute wajib diisi.',
            'jam_masuk.date_format' => 'Field :attribute harus berupa waktu dengan format HH:MM.',

            'jam_pulang.required' => 'Field :attribute wajib diisi.',
            'jam_pulang.date_format' => 'Field :attribute harus berupa waktu dengan format HH:MM.',

            'jam_batas_masuk.required' => 'Field :attribute wajib diisi.',
            'jam_batas_masuk.date_format' => 'Field :attribute harus berupa waktu dengan format HH:MM.',

            'jam_batas_pulang.required' => 'Field :attribute wajib diisi.',
            'jam_batas_pulang.date_format' => 'Field :attribute harus berupa waktu dengan format HH:MM.',

            'toleransi_terlambat.required' => 'Field :attribute wajib diisi.',
            'toleransi_terlambat.integer' => 'Field :attribute harus berupa angka.',
            'toleransi_terlambat.min' => 'Field :attribute minimal :min.',
            'toleransi_terlambat.max' => 'Field :attribute maksimal :max.',
        ];
    }
}
