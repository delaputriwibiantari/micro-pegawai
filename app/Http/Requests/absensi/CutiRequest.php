<?php

namespace App\Http\Requests\absensi;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

final class CutiRequest extends FormRequest
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
            'cuti_id' => 'nullable|string|max:10',
            'jenis_cuti' => 'required|in:TAHUNAN,SAKIT,MELAHIRKAN',
            'keterangan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'total_hari' => 'required|integer|min:0|max:32767',
            'sdm_id' => 'required|exists:mysql.sdm,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'cuti_id' => 'ID Cuti',
            'jenis_cuti' => 'Jenis Cuti',
            'keterangan' => 'Keterangan Cuti',
            'tanggal_mulai' => 'Tanggal Mulai Cuti',
            'tanggal_selesai' => 'Tanggal Selesai Cuti',
            'total_hari' => 'Total Hari Cuti',
            'sdm_id' => 'ID SDM',
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

            'jenis_cuti.nullable' => 'field :attribute wajib diisi.',
            'jenis_cuti.in' => 'field :attribute tidak valid.',

            'keterangan.required' => 'field :attribute wajib diisi.',
            'keterangan.string' => 'field :attribute harus berupa teks.',
            'keterangan.max' => 'field :attribute maksimal :max karakter.',

            'tanggal_mulai.required' => 'field :attribute wajib diisi.',
            'tanggal_mulai.date_format' => 'field :attribute harus berupa waktu',

            'tanggal_selesai.required' => 'field :attribute wajib diisi.',
            'tanggal_selesai.date_format' => 'field :attribute harus berupa waktu',

            'total_hari.required' => 'field :attribute wajib diisi.',
            'total_hari.integer' => 'field :attribute harus berupa angka.',
            'total_hari.min' => 'field :attribute minimal :min.',
        ];
    }
}
