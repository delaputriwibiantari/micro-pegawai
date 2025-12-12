<?php

namespace App\Http\Requests\gaji;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

final class TarifPotonganRequest extends FormRequest
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
            'potongan_id' => 'nullable|string|max:10',
            'nama_potongan' => 'required|string|max:100',
            'tarif_per_kejadian' => 'required|decimal:0,2',
            'deskripsi' => 'required|string|max:255'
        ];
    }

    public function attributes()
    {
        return[
            'potongan_id' => 'Potongan Id',
            'nama_potongan' => 'Nama Potongan',
            'tarif_per_kejadian' => 'Tarif Per Kejadian',
            'deskripsi' => 'Deskripsi',
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
            'nama_potongan.required' => 'Field :attribute wajib diisi.',
            'nama_potongan.string' => 'Field :attribute harus berupa teks.',
            'nama_potongan.max' => 'Field :attribute maksimal :max.',

            'tarif_per_kejadian.required' => 'Field :attribute wajib diisi.',
            'tarif_per_kejadian.decimal' => 'Field :attribute harus berupa angka.',

            'deskripsi.required' => 'Field :attribute wajib diisi.',
            'deskripsi.string' => 'Field :attribute harus berupa teks.',
            'deskripsi.max' => 'Field :attribute maksimal :max.',
        ];
    }
}
