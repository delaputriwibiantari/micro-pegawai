<?php

namespace App\Http\Requests\absensi;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

final class AbsensiRequest extends FormRequest
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
            'absensi_id' => 'nullable|string|max:10',
            // 'jadwal_id' => 'required|exists:att.jadwal_kerja,id',
            'sdm_id' => 'required|exists:mysql.sdm,id',
            // 'jenis_absen_id' => 'required|exists:jenis_absen,jenis_absen_id',
            'total_terlambat' => 'nullable|decimal:0,2',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
        ];
    }

    public function attributes()
    {
        return [
            'absensi_id' => 'ID Absensi',
            'jadwal_id' => 'Jadwal Id',
            'sdm_id' => 'Sdm Id',
            // 'jenis_absen_id' => 'Jenis Absen Id',
            'total_terlambat' => 'Total Terlambat',
            'waktu_mulai' => 'Waktu Mulai',
            'waktu_selesai' => 'Waktu Selesai',
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

    public function messages()
    {
        return [
            'jadwal_id.required' => 'Fileld :attribute wajib diisi.',

            'sdm_id.required' => 'Fileld :attribute wajib diisi.',

            // 'jenis_absen_id.require' => 'Fileld :attribute wajib diisi.',

            // 'total_terlambat.decimal' => 'Fileld :attribute harus berupa angka.',

            'waktu_mulai.required' => 'Fileld :attribute wajib diisi.',
            'waktu_mulai.date_format' => 'Fileld :attribute harus berupa waktu.',

            'waktu_selesai.required' => 'Fileld :attribute wajib diisi.',
            'waktu_selesai.date_format' => 'Fileld :attribute harus berupa waktu.',
        ];
    }
}
