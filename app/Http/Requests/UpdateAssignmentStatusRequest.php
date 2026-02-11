<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:assigned,on_the_way,on_site,completed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
            'notes.max' => 'Catatan maksimal 1000 karakter',
        ];
    }
}