<?php

namespace App\Http\Requests\Person;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PersonUpdateRequest extends FormRequest
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
            'nama_lengkap' => 'required|string|max:50',
            'nama_panggilan' => 'nullable|string|max:30',
            'jk' => 'required|in:l,p',
            'tempat_lahir' => 'required|string|max:30',
            'tanggal_lahir' => 'required|date',
            'agama' => 'nullable|string|max:20',
            'kewarganegaraan' => 'nullable|string|max:50',
            'golongan_darah' => 'nullable|in:A,B,O,AB',
            'nik' => 'nullable|string|max:16',
            'kk' => 'nullable|string|max:16',
            'alamat' => 'nullable|string|max:100',
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'id_desa' => 'nullable|integer|exists:ref_almt_desa,id_desa',
            'npwp' => 'nullable|string|max:30',
            'no_hp' => [
            'nullable',
            'string',
            'max:13',
            'regex:/^(?:08[0-9]{8,11}|[1-9][0-9]{7,14})$/' ],
            'email' => [
            'required',
            'string',
            'max:254',
            'regex:/^(?!.*\.\.)[A-Za-z0-9._%+\-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/' ],
            'foto' => 'nullable|image|max:2048|mimes:jpg,jpeg,png|mimetypes:image/jpeg,image/png',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_lengkap' => 'Nama Lengkap',
            'nama_panggilan' => 'Nama Panggilan',
            'jk' => 'Jenis Kelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'agama' => 'Agama',
            'kewarganegaraan' => 'Kewarganegaraan',
            'golongan_darah' => 'Golongan Darah',
            'nik' => 'NIK',
            'kk' => 'Nomor KK',
            'alamat' => 'Alamat',
            'rt' => 'RT',
            'rw' => 'RW',
            'id_desa' => 'Desa',
            'npwp' => 'NPWP',
            'no_hp' => 'Nomor HP',
            'email' => 'Email',
            'foto' => 'Foto',
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
            'nama_lengkap.required' => 'Field :attribute wajib diisi.',
            'nama_lengkap.string' => 'Field :attribute harus berupa teks.',
            'nama_lengkap.max' => 'Field :attribute maksimal :max karakter.',
            'nama_panggilan.string' => 'Field :attribute harus berupa teks.',
            'nama_panggilan.max' => 'Field :attribute maksimal :max karakter.',
            'jk.required' => 'Field :attribute wajib diisi.',
            'jk.in' => 'Field :attribute harus p atau p.',
            'tempat_lahir.required' => 'Field :attribute wajib diisi.',
            'tempat_lahir.string' => 'Field :attribute harus berupa teks.',
            'tempat_lahir.max' => 'Field :attribute maksimal :max karakter.',
            'tanggal_lahir.required' => 'Field :attribute wajib diisi.',
            'tanggal_lahir.date' => 'Field :attribute harus berupa tanggal yang valid.',
            'agama.string' => 'Field :attribute harus berupa teks.',
            'agama.max' => 'Field :attribute maksimal :max karakter.',
            'kewarganegaraan.string' => 'Field :attribute harus berupa teks.',
            'golongan_darah.in' => 'Field :attribute harus salah satu dari: A, B, O, AB.',
            'nik.string' => 'Field :attribute harus berupa teks.',
            'nik.max' => 'Field :attribute maksimal :max karakter.',
            'kk.string' => 'Field :attribute harus berupa teks.',
            'kk.max' => 'Field :attribute maksimal :max karakter.',
            'alamat.string' => 'Field :attribute harus berupa teks.',
            'alamat.max' => 'Field :attribute maksimal :max karakter.',
            'rt.string' => 'Field :attribute harus berupa teks.',
            'rt.max' => 'Field :attribute maksimal :max karakter.',
            'rw.string' => 'Field :attribute harus berupa teks.',
            'rw.max' => 'Field :attribute maksimal :max karakter.',
            'id_desa.integer' => 'Field :attribute harus berupa angka.',
            'id_desa.exists' => 'Field :attribute tidak ditemukan.',
            'npwp.string' => 'Field :attribute harus berupa teks.',
            'npwp.max' => 'Field :attribute maksimal :max karakter.',
            'no_hp.string' => 'Nomor HP harus berupa teks.',
            'no_hp.max' => 'Email tidak boleh lebih dari 13 karakter.',
            'no_hp.regex'  => 'Nomor HP tidak valid. Gunakan hanya angka 0–9 tanpa spasi atau simbol.
                           Untuk nomor Indonesia harus diawali 08 dengan panjang 10–13 digit,
                           atau nomor internasional 8–15 digit.',
            'email.required' => 'Email wajib diisi.',
            'email.string'   => 'Email harus berupa teks.',
            'email.max'      => 'Email tidak boleh lebih dari 254 karakter.',
            'email.regex'    => 'Format email tidak valid. Gunakan format local-part@domain,
                                contoh: nama+tag@contoh.co.id.
                                Pastikan tidak ada spasi atau dua titik berurutan.',
            'foto.image' => 'Field :attribute harus berupa gambar.',
            'foto.max' => 'Field :attribute maksimal :max KB.',
            'foto.mimes' => 'Field :attribute harus bertipe: jpg, jpeg, png.',
            'foto.mimetypes' => 'Field :attribute harus bertipe: image/jpeg, image/png.',
        ];
    }
}
