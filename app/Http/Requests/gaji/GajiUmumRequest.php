<?php

namespace App\Http\Requests\gaji;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GajiUmumRequest extends FormRequest
{
   public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'umum_id' => 'nullable|string|max:10',
            'nominal' => 'required|numeric|min:0',
        ];
    }

    public function attributes(): array
    {
        return [
            'umum_id' => 'ID Umum',
            'nominal' => 'Nominal',
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
            'nominal.required' => 'Field :attribute wajib diisi.',
            'nominal.numeric' => 'Field :attribute harus berupa angka.',
            'nominal.min' => 'Field :attribute minimal :min.',
        ];
    }
}
