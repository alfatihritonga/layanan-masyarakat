<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleteAssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'completion_notes' => 'required|string|min:10|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'completion_notes.required' => 'Catatan penyelesaian wajib diisi',
            'completion_notes.min' => 'Catatan penyelesaian minimal 10 karakter',
            'completion_notes.max' => 'Catatan penyelesaian maksimal 1000 karakter',
        ];
    }
}