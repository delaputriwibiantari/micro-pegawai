<?php

namespace App\Http\Requests\gaji;

use Illuminate\Foundation\Http\FormRequest;

class GajiManualRequest extends FormRequest
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
            'periode_id' => 'required|exists:gaji_priode,periode_id',
            'id_sdm' => 'required|integer|exists:mysql.sdm,id_sdm'
        ];
    }

    public function attributes(): array
    {
        return [
            'periode_id' => 'Periode Gaji',
            'sdm_id'     => 'Pegawai',
        ];
    }

        public function messages(): array
    {
        return [
            'periode_id.required' => 'Periode gaji wajib dipilih.',
            'periode_id.exists'   => 'Periode gaji tidak ditemukan atau tidak aktif.',

            'id_sdm.required' => 'Pegawai wajib dipilih.',
            'id_sdm.exists'   => 'Pegawai tidak ditemukan di database SDM.',
        ];
    }
}

