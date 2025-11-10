<?php

namespace App\Http\Requests\Sdm;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SdmDokumenUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_jenis_dokumen' => 'nullable|integer|exists:ref_jenis_dokumen,id_jenis_dokumen',
            'nama_dokumen' => 'required|string|max:255',
            'file_dokumen' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_jenis_dokumen' => 'Jenjang Dokumen',
            'nama_dokumen' => 'Nama Dokumen',
            'file_dokumen' => 'File Dokumen',
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
            'id_jenis_dokumen.integer' => 'Jenis Dokumen harus berupa angka.',
            'id_jenis_dokumen.exists' => 'Jenis Dokumen tidak ditemukan.',

            'nama_dokumen.required' => 'Nama Dokumen wajib diisi.',
            'nama_dokumen.string' => 'Nama Dokumen harus berupa teks.',
            'nama_dokumen.max' => 'Nama Dokumen tidak boleh lebih dari :max karakter.',

            'file_dokumen.file' => 'File dokumen harus berupa file.',
            'file_dokumen.max' => 'File dokumen maksimal 10MB.',
            'file_dokumen.mimes' => 'File dokumen harus bertipe pdf, jpg, jpeg, atau png.',
        ];
    }
}
