<?php

namespace App\Http\Requests\Sdm;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SdmPendidikanUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_jenjang_pendidikan' => 'nullable|integer|exists:ref_jenjang_pendidikan,id_jenjang_pendidikan',
            'institusi' => 'nullable|string|max:100',
            'sumber_biaya' => 'nullable|in:BEASISWA,MANDIRI',
            'jenis_nilai' => 'nullable|in:IPK,NILAI',
            'jurusan' => 'nullable|string|max:100',
            'tahun_masuk' => 'nullable|numeric|digits:4|min:1900|max:2099',
            'tahun_lulus' => 'nullable|numeric|digits:4|min:1900|max:2099',
            'file_ijazah' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png',
            'file_transkip' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_jenjang_pendidikan' => 'Jenjang Pendidikan',
            'institusi' => 'Nama Sekolah',
            'jurusan' => 'Jurusan',
            'tahun_masuk' => 'Tahun Masuk',
            'tahun_lulus' => 'Tahun Lulus',
            'sumber_biaya' => 'Sumber Biaya',
            'jenis_nilai' => 'Jenis Nilai',
            'file_ijazah' => 'File Ijazah',
            'file_transkip' => 'File Transkip',
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
            'id_jenjang_pendidikan.integer' => 'Jenjang pendidikan harus berupa angka.',
            'id_jenjang_pendidikan.exists' => 'Jenjang pendidikan tidak ditemukan.',
            'institusi.string' => 'Institusi harus berupa teks.',
            'institusi.max' => 'Institusi maksimal 100 karakter.',
            'sumber_biaya.in' => 'Sumber biaya harus BEASISWA atau MANDIRI.',
            'jenis_nilai.in' => 'Jenis nilai harus IPK atau NILAI.',
            'jurusan.string' => 'Jurusan harus berupa teks.',
            'jurusan.max' => 'Jurusan maksimal 100 karakter.',
            'tahun_masuk.numeric' => 'Tahun masuk harus berupa angka.',
            'tahun_masuk.digits' => 'Tahun masuk harus 4 digit.',
            'tahun_masuk.min' => 'Tahun masuk minimal 1900.',
            'tahun_masuk.max' => 'Tahun masuk maksimal 2099.',
            'tahun_lulus.numeric' => 'Tahun lulus harus berupa angka.',
            'tahun_lulus.digits' => 'Tahun lulus harus 4 digit.',
            'tahun_lulus.min' => 'Tahun lulus minimal 1900.',
            'tahun_lulus.max' => 'Tahun lulus maksimal 2099.',
            'file_ijazah.file' => 'File ijazah harus berupa file.',
            'file_ijazah.max' => 'File ijazah maksimal 10MB.',
            'file_ijazah.mimes' => 'File ijazah harus bertipe pdf, jpg, jpeg, atau png.',
            'file_transkip.file' => 'File transkip harus berupa file.',
            'file_transkip.max' => 'File transkip maksimal 10MB.',
            'file_transkip.mimes' => 'File transkip harus bertipe pdf, jpg, jpeg, atau png.',
        ];
    }
}
