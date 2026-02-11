<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignRelawanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'relawan_ids' => 'required|array|min:1',
            'relawan_ids.*' => 'required|exists:relawan,id',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'relawan_ids.required' => 'Relawan wajib dipilih',
            'relawan_ids.array' => 'Format data relawan tidak valid',
            'relawan_ids.min' => 'Minimal pilih 1 relawan',
            'relawan_ids.*.exists' => 'Relawan tidak ditemukan',
            'notes.max' => 'Catatan maksimal 1000 karakter',
        ];
    }
}