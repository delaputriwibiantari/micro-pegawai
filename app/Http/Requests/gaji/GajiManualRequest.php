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
            'id_sdm' => 'required|integer|exists:mysql.sdm,id_sdm',

            'komponen_id' => 'sometimes|required|exists:komponen_gaji,komponen_id',
            'nominal'     => 'sometimes|required|numeric|min:0',
            'keterangan'  => 'sometimes|nullable|string|max:255',

            'transaksi_id' => 'sometimes|required|exists:gaji_trx,transaksi_id',
        ];
    }

    public function attributes(): array
    {
        return [
            'periode_id' => 'Periode Gaji',
            'sdm_id'     => 'Pegawai',
            'komponen_id' => 'Komponen Gaji',
            'nominal'     => 'Nominal',
            'keterangan'  => 'Keterangan',
            'transaksi_id' => 'ID Transaksi',
        ];
    }

        public function messages(): array
    {
        return [
            'periode_id.required' => 'Periode gaji wajib dipilih.',
            'periode_id.exists'   => 'Periode gaji tidak ditemukan atau tidak aktif.',

            'id_sdm.required' => 'Pegawai wajib dipilih.',
            'id_sdm.exists'   => 'Pegawai tidak ditemukan di database SDM.',

            'komponen_id.required' => 'Komponen wajib dipilih.',
            'komponen_id.exists'   => 'Komponen tidak valid.',

            'nominal.required' => 'Nominal wajib diisi.',
            'nominal.numeric'  => 'Nominal harus berupa angka.',

            'transaksi_id.required' => 'Transaksi gaji tidak ditemukan.',
            'transaksi_id.exists'   => 'Transaksi gaji tidak valid.',
        ];
    }
}

