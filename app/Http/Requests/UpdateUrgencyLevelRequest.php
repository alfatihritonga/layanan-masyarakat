<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUrgencyLevelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'urgency_level' => 'required|in:low,medium,high,critical',
        ];
    }

    public function messages(): array
    {
        return [
            'urgency_level.required' => 'Tingkat urgensi wajib dipilih',
            'urgency_level.in' => 'Tingkat urgensi tidak valid',
        ];
    }
}