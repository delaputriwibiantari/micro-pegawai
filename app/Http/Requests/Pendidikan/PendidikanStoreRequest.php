<?php

namespace App\Http\Requests\Pendidikan;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PendidikanStoreRequest extends FormRequest
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
            'id_sdm' => 'required|integer|exists:sdm.id',
            'institusi' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'tahun_masuk' => 'required|string|max:255',
            'tahun_lulus' => 'required|string|max:255',
            'jenis_nilai' => 'required|in:IPK,NILAI',
            'sks' => 'nullable|integer|min:0|max:10',
            'sumber_biaya' => 'required|in:MANDIRI,BEASISWA',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_sdm' => 'Pegawai',
            'institusi' => 'Institusi Pendidikan',
            'jurusan' => 'Jurusan',
            'tahun_masuk' => 'Tahun Masuk',
            'tahun_lulus' => 'Tahun Lulus',
            'jenis_nilai' => 'Jenis Nilai',
            'sks' => 'SKS',
            'sumber_biaya' => 'Sumber Biaya',
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
            'id_sdm.required' => 'Data Pegawai wajib dipilih.',
            'id_sdm.integer' => 'Data Pegawai harus berupa angka.',
            'id_sdm.exists' => 'Data Pegawai yang dipilih tidak valid.',

            'institusi.required' => 'Institusi Pendidikan wajib diisi.',
            'institusi.string' => 'Institusi Pendidikan harus berupa teks.',
            'institusi.max' => 'Institusi Pendidikan tidak boleh lebih dari :max karakter.',

            'jurusan.required' => 'Jurusan wajib diisi.',
            'jurusan.string' => 'Jurusan harus berupa teks.',
            'jurusan.max' => 'Jurusan tidak boleh lebih dari :max karakter.',

            'tahun_masuk.required' => 'Tahun Masuk wajib diisi.',
            'tahun_masuk.string' => 'Tahun Masuk harus berupa teks.',
            'tahun_masuk.max' => 'Tahun Masuk tidak boleh lebih dari :max karakter.',

            'tahun_lulus.required' => 'Tahun Lulus wajib diisi.',
            'tahun_lulus.string' => 'Tahun Lulus harus berupa teks.',
            'tahun_lulus.max' => 'Tahun Lulus tidak boleh lebih dari :max karakter.',

            'jenis_nilai.required' => 'Jenis Nilai wajib dipilih.',
            'jenis_nilai.in' => 'Jenis Nilai harus IPK atau NILAI.',

            'sks.integer' => 'SKS harus berupa angka.',
            'sks.min' => 'SKS tidak boleh kurang dari :min.',
            'sks.max' => 'SKS tidak boleh lebih dari :max.',

            'sumber_biaya.required' => 'Sumber Biaya wajib dipilih.',
            'sumber_biaya.in' => 'Sumber Biaya harus MANDIRI atau BEASISWA.',
        ];
    }
}
