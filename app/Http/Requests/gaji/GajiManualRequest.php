<?php

namespace App\Http\Requests\Gaji;

use App\Models\sdm\SdmStruktural;
use App\Models\Gaji\GajiPeriode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class GajiManualRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'periode_id' => [
                'required',
                Rule::exists(GajiPeriode::class, 'periode_id'),
            ],
            'sdm_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    try {
                        $aktif = SdmStruktural::where('id_sdm', $value)
                            ->whereNull('file_sk_keluar')
                            ->exists();

                        if (!$aktif) {
                            $fail('Pegawai sudah tidak aktif (sudah keluar).');
                        }
                    } catch (\Throwable $e) {
                         Log::error('Validasi SDM gagal', [
                            'error' => $e->getMessage(),
                            'sdm_id' => $value,
                        ]);

                        $fail('Terjadi kesalahan validasi data pegawai.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'periode_id.required' => 'Periode gaji wajib dipilih.',
            'periode_id.exists' => 'Periode gaji tidak valid.',
            'sdm_id.required' => 'Pegawai wajib dipilih.',
        ];
    }
}
