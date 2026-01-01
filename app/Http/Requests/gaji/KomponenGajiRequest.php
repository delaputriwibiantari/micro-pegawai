<?php

namespace App\Http\Requests\gaji;

use Illuminate\Foundation\Http\FormRequest;

class KomponenGajiRequest extends FormRequest
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
            'komponen_id' => 'nullable|string|max:10',
            'nama_komponen' => 'required|string|max:100',
            'jenis'         => 'required|in:PENGHASIL,POTONGAN',
            'deskripsi'     => 'nullable|string',
            'is_umum' => 'nullable|boolean',
            'aturan_nominal' => 'nullable|in:manual,gaji_umum,tarif_potongan,tarif_lembur',
            'referensi_id' => 'nullable|string|max:10'
        ];
    }

    public function attributes(): array
    {
        return [
            'komponen_id'   => 'Kode Komponen',
            'nama_komponen' => 'Nama Komponen',
            'jenis'         => 'Jenis Komponen',
            'deskripsi'     => 'Deskripsi',
            'is_umum'       => 'Tipe Umum',
            'aturan_nominal' => 'Aturan Nominal',
            'referensi_id' => 'ID Referensi',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_komponen.required' => 'Nama Komponen attribute wajib diisi.',
            'nama_komponen.string'   => 'Nama Komponen harus berupa teks.',
            'jenis.required'         => 'Jenis attribute wajib dipilih.',
            'jenis.in'               => 'Jenis attribute harus PENGHASIL atau POTONGAN.',
            'aturan_nominal.in'      => 'Aturan Nominal attribute harus manual, gaji_umum, tarif_potongan, atau tarif_lembur.',
            'referensi_id.string'    => 'ID Referensi harus berupa teks.',
        ];
    }

}
