<?php

namespace App\Http\Requests\gaji;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GajiJabatanRequest extends FormRequest
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
            'gaji_master_id' => 'required|string|max:10',
            'komponen_id' => 'required|exists:gaji.komponen_gaji,komponen_id',
            'nominal' => 'required|numeric|min:0',
            'id_jabatan' => 'required|exists:mysql.master_jabatan,id_jabatan',

        ];
    }

    public function attributes(): array
    {
        return [
            'gaji_master_id' => 'Gaji Master ID',
            'komponen_id'   => 'Kode Komponen',
            'nominal'       => 'Nominal',
            'id_jabatan'  => 'Id Jabatan',

        ];
    }

    public function messages(): array
    {
        return [
            'gaji_master_id.required' => 'Gaji master id harus diisi.',
            'gaji_master_id.string' => 'Gaji master id harus berupa string.',
            'gaji_master_id.max' => 'Gaji master id maksimal 10 karakter.',
            'komponen_id.required' => 'Komponen id harus diisi.',
            'komponen_id.exists' => 'Komponen id tidak ditemukan.',
            'nominal.required' => 'Nominal harus diisi.',
            'nominal.numeric' => 'Nominal harus berupa angka.',
            'nominal.min' => 'Nominal minimal 0.',
            'id_jabatan.required' => 'ID Jabatan harus diisi.',
            'id_jabatan.exists'   => 'ID Jabatan tidak ditemukan di database.',
        ];
    }
}
