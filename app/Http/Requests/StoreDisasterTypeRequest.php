<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDisasterTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|unique:disaster_types,name',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
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
            'icon.max' => 'Nama icon maksimal 100 karakter',
            'color.regex' => 'Format warna harus hex (contoh: #FF5733)',
        ];
    }
}