<?php

namespace App\Http\Requests\gaji;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TarifLemburRequest extends FormRequest
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
            'tarif_id' => 'nullable|integer|max:10',
            'jenis_lembur' => 'required|in:BIASA,LIBUR',
            'tarif_per_jam' => 'required|decimal:0,2',
            'berlaku_mulai' => 'required|date',
        ];
    }

    public function attributes()
    {
        return[
            'tarif_id' => 'ID Tarif',
            'jenis_lembur' => 'Jenis Lembur',
            'tarif_per_jam' => 'Tarif Per Jam',
            'berlaku_mulai' => 'Berlaku mulai',
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

    public function messages()
    {
        return [
            'jenis_lembur.required' => 'Field :attribute wajib diisi.',
            'jenis_lembur.in' => 'Field :attribute harus berupa BIASA, LIBUR.',

            'tarif_per_jam.required' => 'Field :attribute wajib diisi.',
            'tarif_per_jam.decimal' => 'Field :attribute harus berupa angka.',

            'berlaku_mulai.required' => 'Field :attribute wajib diisi.',
            'berlaku_mulai.date' => 'Field :attribute harus berupa tanggal.',
        ];
    }
}
