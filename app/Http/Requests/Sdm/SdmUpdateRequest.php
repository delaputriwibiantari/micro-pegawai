<?php

namespace App\Http\Requests\Sdm;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SdmUpdateRequest extends FormRequest
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

    /**
     * Handle failed validation response.
     */
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

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'id_person.integer' => 'Data :attribute harus berupa angka.',
            'id_person.exists' => 'Data :attribute yang dipilih tidak valid.',

            'nip.string' => ':attribute harus berupa teks.',
            'nip.max' => ':attribute tidak boleh lebih dari :max karakter.',

            'status_pegawai.required' => ':attribute wajib dipilih.',
            'status_pegawai.in' => ':attribute harus TETAP atau KONTRAK.',

            'tipe_pegawai.required' => ':attribute wajib dipilih.',
            'tipe_pegawai.in' => ':attribute harus FULL TIME atau PART TIME.',

            'tanggal_masuk.required' => ':attribute wajib diisi.',
            'tanggal_masuk.date' => 'Format :attribute tidak valid.',
        ];
    }
}
