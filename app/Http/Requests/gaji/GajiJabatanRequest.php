<?php

namespace App\Http\Requests\gaji;

use App\Models\Gaji\GajiJabatan;
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
            'gaji_master_id' => 'nullable|string|max:10',
            'komponen_id' => 'required|exists:gaji.komponen_gaji,komponen_id',
            'id_jabatan' => 'required|exists:mysql.master_jabatan,id_jabatan',
            'use_override' => 'nullable|boolean',
            'override_nominal' => 'nullable|numeric|min:0',

        ];
    }

    public function attributes(): array
    {
        return [
            'gaji_master_id' => 'Gaji Master ID',
            'komponen_id'   => 'Kode Komponen',
            'id_jabatan'  => 'Id Jabatan',

        ];
    }

    public function messages(): array
    {
        return [

            'komponen_id.required' => 'Komponen id harus diisi.',
            'komponen_id.exists' => 'Komponen id tidak ditemukan.',
            'id_jabatan.required' => 'ID Jabatan harus diisi.',
            'id_jabatan.exists'   => 'ID Jabatan tidak ditemukan di database.',
            'use_override.boolean' => 'Gunakan Override harus berupa boolean.',
            'override_nominal.numeric' => 'Nominal Override harus berupa angka.',
            'override_nominal.min' => 'Nominal Override minimal 0.',
        ];
    }

     protected function prepareForValidation(): void
    {
        // Konversi use_override ke boolean
        if ($this->has('use_override')) {
            $this->merge([
                'use_override' => filter_var($this->input('use_override'), FILTER_VALIDATE_BOOLEAN)
            ]);
        }

        // Jika use_override = true dan ada override_nominal, set nominal = override_nominal
        if ($this->boolean('use_override') && $this->has('override_nominal') && $this->input('override_nominal')) {
            $this->merge([
                'nominal' => $this->input('override_nominal')
            ]);
        }

        // Jika use_override = false, pastikan override_nominal = null
        if (!$this->boolean('use_override')) {
            $this->merge([
                'override_nominal' => null
            ]);
        }
    }

    /**
     * Configure the validator instance.
     * TAMBAH: Validasi custom
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Validasi konsistensi: jika use_override = true, override_nominal harus diisi
            if ($this->boolean('use_override')) {
                if (!$this->filled('override_nominal')) {
                    $validator->errors()->add('override_nominal', 'Nominal Override harus diisi jika Gunakan Override = true.');
                }
            }

            // Validasi: cek duplikasi komponen_id untuk jabatan yang sama
            if ($this->filled('komponen_id') && $this->filled('id_jabatan')) {
                $existing = GajiJabatan::where('komponen_id', $this->input('komponen_id'))
                    ->where('id_jabatan', $this->input('id_jabatan'))
                    ->when($this->route('id'), function ($query, $id) {
                        $query->where('id', '!=', $id);
                    })
                    ->exists();

                if ($existing) {
                    $validator->errors()->add('komponen_id', 'Komponen gaji ini sudah ada untuk jabatan yang dipilih.');
                }
            }
        });
    }
}
