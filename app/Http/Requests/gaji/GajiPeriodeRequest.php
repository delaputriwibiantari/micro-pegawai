<?php

namespace App\Http\Requests\gaji;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GajiPeriodeRequest extends FormRequest
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
            'periode_id' => 'nullable|string|max:10',
            'tahun' => 'required|numeric|digits:4|min:2000|max:2099',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'status' => 'required|in:DRAFT,FINAL,CLOSED',
        ];
    }

    public function attributes()
    {
        return [
            'periode_id' => 'Periode Id',
            'tahun' => 'Tahun',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'status' => 'Status',
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
            'tahun.required' => 'Field :attribute wajib diisi.',
            'tahun.numeric' => 'Field :attribute harus berupa angka.',
            'tahun.digits' => 'Field :attribute harus berupa angka dengan panjang 4.',
            'tahun.min' => 'Field :attribute minimal :min.',
            'tahun.max' => 'Field :attribute maksimal :max.',

            'tanggal_mulai.required' => 'Field :attribute wajib diisi.',
            'tanggal_mulai.date' => 'Field :attribute harus berupa tanggal.',

            'tanggal_selesai.required' => 'Field :attribute wajib diisi.',
            'tanggal_selesai.date' => 'Field :attribute harus berupa tanggal.',

            'status.required' => 'Field :attribute wajib diisi.',
            'status.in' => 'Field :attribute harus berupa DRAFT, FINAL, CLOSED.',
        ];
    }
}
