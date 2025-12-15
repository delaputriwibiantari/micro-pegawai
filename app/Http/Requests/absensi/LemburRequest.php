<?php

namespace App\Http\Requests\absensi;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LemburRequest extends FormRequest
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
            'lembur_id' => 'nullable|string|max:10',
            'sdm_id' => 'required|exists:mysql.sdm,id',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'durasi_jam' => 'required|decimal:0,2'
        ];
    }

    public function attributes(): array
    {
        return [
            'lembur_id' => 'ID Lembur',
            'sdm_id' => 'SDM',
            'jam_mulai' => 'Jam Mulai',
            'jam_selesai' => 'Jam Selesai',
            'durasi_jam' => 'Durasi Jam',
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

            'jam_mulai.required' => 'field :attribute wajib diisi.',
            'jam_mulai.date_format' => 'field :attribute harus berupa waktu',

            'jam_selesai.required' => 'field :attribute wajib diisi.',
            'jam_selesai.date_format' => 'field :attribute harus berupa waktu',

            'durasi_jam.required' => 'field :attribute wajib diisi.',
            'durasi_jam.decimal' => 'field :attribute harus berupa angka.',
        ];
    }
}
