<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRelawanRequest extends FormRequest
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
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|unique:relawan,email',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string|max:100',
            'kabupaten_kota' => 'required|string|max:100',
            'status_ketersediaan' => 'required|in:available,on_duty,unavailable',
            'skill' => 'nullable|array',
            'skill.*' => 'string',
            'skill_manual' => 'nullable|string|max:255',
            'tahun_bergabung' => 'required|integer|min:2000|max:' . date('Y'),
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'tahun_bergabung.min' => 'Tahun bergabung minimal 2000',
        ];
    }
}
