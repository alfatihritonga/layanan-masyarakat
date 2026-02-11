<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRelawanRequest extends FormRequest
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
        $relawanId = $this->route('relawan') ?? $this->route('id');

        return [
            'nama' => 'sometimes|required|string|max:100',
            'no_hp' => 'sometimes|required|string|max:20',
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('relawan', 'email')->ignore($relawanId)
            ],
            'alamat' => 'sometimes|required|string',
            'kecamatan' => 'sometimes|required|string|max:100',
            'kabupaten_kota' => 'sometimes|required|string|max:100',
            'status_ketersediaan' => 'sometimes|required|in:available,on_duty,unavailable',
            'skill' => 'nullable|array',
            'skill.*' => 'string',
            'tahun_bergabung' => 'sometimes|required|integer|min:2000|max:' . date('Y'),
        ];
    }
}
