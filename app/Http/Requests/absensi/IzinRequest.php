<?php

namespace App\Http\Requests\absensi;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class IzinRequest extends FormRequest
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
            'izin_id' => 'nullable|string|max:10',
            'jenis_izin' => 'required|in:PRIBADI,KELUARGA',
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'sdm_id' => 'required|exists:mysql.sdm,id',
        ];
    }

     public function attributes(): array
    {
        return [
            'izin_id' => 'ID Izin',
            'jenis_izin' => 'Jenis Izin',
            'keterangan' => 'Keterangan Izin',
            'tanggal' => 'Tanggal Izin',
            'jam_mulai' => 'Jam Mulai Izin',
            'jam_selesai' => 'Jam Selesai Izin',
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
            ],422)
        );
     }

     public function messages()
    {
        return [
            'jenis_izin.required' => 'field :attribute wajib diisi.',
            'jenis_izin.in' => 'field :attribute tidak valid.',

            'keterangan.required' => 'field :attribute wajib diisi.',
            'keterangan.string' => 'field :attribute harus berupa teks.',
            'keterangan.max' => 'field :attribute maksimal :max karakter.',

            'tanggal.required' => 'field :attribute wajib diisi.',
            'tanggal.date' => 'field :attribute harus berupa tanggal yang valid.',

            'jam_mulai.required' => 'field :attribute wajib diisi.',
            'jam_mulai.date_format' => 'field :attribute harus berupa jam (HH:MM).',

            'jam_selesai.required' => 'field :attribute wajib diisi.',
            'jam_selesai.date_format' => 'field :attribute harus berupa jam (HH:MM).',
            'jam_selesai.after' => 'field :attribute harus setelah jam mulai.',

            'sdm_id.required' => 'field :attribute wajib diisi.',
            'sdm_id.exists' => 'data :attribute tidak ditemukan.',
        ];
    }
}
