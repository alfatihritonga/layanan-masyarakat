<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminNotesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'admin_notes' => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'admin_notes.required' => 'Catatan admin wajib diisi',
            'admin_notes.max' => 'Catatan admin maksimal 1000 karakter',
        ];
    }
}