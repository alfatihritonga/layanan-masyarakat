<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comment' => 'required|string|min:5|max:1000',
            'is_internal' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'comment.required' => 'Komentar wajib diisi',
            'comment.min' => 'Komentar minimal 5 karakter',
            'comment.max' => 'Komentar maksimal 1000 karakter',
            'is_internal.boolean' => 'Format is_internal tidak valid',
        ];
    }

    /**
     * Prepare data for validation
     */
    protected function prepareForValidation(): void
    {
        // Admin dapat membuat internal comment, user biasa tidak bisa
        if (!$this->user() || !$this->user()->isAdmin()) {
            $this->merge([
                'is_internal' => false,
            ]);
        }
    }
}