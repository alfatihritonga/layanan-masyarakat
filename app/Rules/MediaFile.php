<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MediaFile implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value->isValid()) {
            $fail('File tidak valid');
            return;
        }

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
    }
}
