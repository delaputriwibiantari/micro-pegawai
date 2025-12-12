<?php

namespace App\Http\Requests\gaji;

use Illuminate\Foundation\Http\FormRequest;

class GajiManualRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // wajib
            'periode_id' => 'required|exists:gaji.gaji_periode,periode_id',
            'sdm_id'     => 'required|exists:mysql.sdm,id',

            // komponen manual (opsional)
            'manual' => 'sometimes|array',
            'manual.*.komponen_id' => 'required|exists:gaji.komponen_gaji,komponen_id',
            'manual.*.nominal'     => 'required|numeric|min:0',
            'manual.*.keterangan'  => 'nullable|string|max:255',

            // transaksi id untuk update detail
            'transaksi_id' => 'sometimes|required|exists:gaji.gaji_trx,transaksi_id',
        ];
    }

    public function attributes(): array
    {
        return [
            'periode_id' => 'Periode Gaji',
            'sdm_id'     => 'Pegawai',

            'manual.*.komponen_id' => 'Komponen Gaji',
            'manual.*.nominal'     => 'Nominal',
            'manual.*.keterangan'  => 'Keterangan',

            'transaksi_id' => 'ID Transaksi',
        ];
    }

    public function messages(): array
    {
        return [
            'periode_id.required' => 'Periode gaji wajib dipilih.',
            'periode_id.exists'   => 'Periode gaji tidak ditemukan atau tidak aktif.',

            'sdm_id.required' => 'Pegawai wajib dipilih.',
            'sdm_id.exists'   => 'Pegawai tidak ditemukan.',

            'manual.*.komponen_id.required' => 'Komponen wajib dipilih.',
            'manual.*.komponen_id.exists'   => 'Komponen tidak valid.',

            'manual.*.nominal.required' => 'Nominal wajib diisi.',
            'manual.*.nominal.numeric'  => 'Nominal harus berupa angka.',

            'transaksi_id.required' => 'Transaksi gaji tidak ditemukan.',
            'transaksi_id.exists'   => 'Transaksi gaji tidak valid.',
        ];
    }
}
