<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDisasterTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $disasterTypeId = $this->route('disaster_type') ?? $this->route('id');

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::unique('disaster_types', 'name')->ignore($disasterTypeId)
            ],
            'description' => 'nullable|string|max:500',
            'icon_svg' => 'nullable|string',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama jenis bencana wajib diisi',
            'name.max' => 'Nama maksimal 100 karakter',
            'name.unique' => 'Nama jenis bencana sudah ada',
            'description.max' => 'Deskripsi maksimal 500 karakter',
            'color.regex' => 'Format warna harus hex (contoh: #FF5733)',
        ];
    }
}