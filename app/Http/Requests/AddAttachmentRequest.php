<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAttachmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                function ($attribute, $value, $fail) {
                    $mimeType = $value->getMimeType();
                    
                    // Check if image
                    if (str_starts_with($mimeType, 'image/')) {
                        $allowedImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                        
                        if (!in_array($mimeType, $allowedImageTypes)) {
                            $fail('File harus berupa gambar dengan format: jpeg, jpg, png, gif, atau webp.');
                            return;
                        }
                        
                        // Max 3MB for images
                        if ($value->getSize() > 3 * 1024 * 1024) {
                            $fail('Ukuran gambar maksimal 3MB.');
                            return;
                        }
                    }
                    // Check if video
                    elseif (str_starts_with($mimeType, 'video/')) {
                        $allowedVideoTypes = ['video/mp4', 'video/mpeg', 'video/quicktime', 'video/x-msvideo'];
                        
                        if (!in_array($mimeType, $allowedVideoTypes)) {
                            $fail('File harus berupa video dengan format: mp4, mpeg, mov, atau avi.');
                            return;
                        }
                        
                        // Max 10MB for videos
                        if ($value->getSize() > 10 * 1024 * 1024) {
                            $fail('Ukuran video maksimal 10MB.');
                            return;
                        }
                    }
                    else {
                        $fail('File harus berupa gambar atau video.');
                    }
                },
            ],
            'description' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'File lampiran wajib dipilih',
            'file.file' => 'File tidak valid',
            'description.max' => 'Deskripsi maksimal 255 karakter',
        ];
    }
}