<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'urgency_level' => 'nullable|in:low,medium,high,critical',
            'admin_notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'urgency_level.in' => 'Tingkat urgensi tidak valid',
            'admin_notes.max' => 'Catatan admin maksimal 1000 karakter',
        ];
    }
}