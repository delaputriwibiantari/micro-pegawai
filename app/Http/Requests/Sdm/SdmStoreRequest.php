<?php

namespace App\Http\Requests\Sdm;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SdmStoreRequest extends FormRequest
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
            'id_person' => 'nullable|integer|exists:person,id',
            'nip' => 'nullable|string|max:16',
            'status_pegawai' => 'required|in:TETAP,KONTRAK',
            'tipe_pegawai' => 'required|in:FULL TIME,PART TIME',
            'tanggal_masuk' => 'required|date',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_person' => 'Pegawai',
            'nip' => 'NIP',
            'status_pegawai' => 'Status Pegawai',
            'tipe_pegawai' => 'Tipe Pegawai',
            'tanggal_masuk' => 'Tanggal Masuk',
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
            'id_person.integer' => 'Data Pegawai harus berupa angka.',
            'id_person.exists' => 'Data Pegawai yang dipilih tidak valid.',

            'nip.string' => 'NIP harus berupa teks.',
            'nip.max' => 'NIP tidak boleh lebih dari :max karakter.',

            'status_pegawai.required' => 'Status Pegawai wajib dipilih.',
            'status_pegawai.in' => 'Status Pegawai harus TETAP atau KONTRAK.',

            'tipe_pegawai.required' => 'Tipe Pegawai wajib dipilih.',
            'tipe_pegawai.in' => 'Tipe Pegawai harus FULL TIME atau PART TIME.',

            'tanggal_masuk.required' => 'Tanggal Masuk wajib diisi.',
            'tanggal_masuk.date' => 'Format Tanggal Masuk tidak valid.',
        ];
    }
}
