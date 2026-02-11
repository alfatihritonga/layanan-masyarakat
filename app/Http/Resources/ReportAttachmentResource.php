<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportAttachmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'file_name' => $this->file_name,
            'file_type' => $this->file_type,
            'file_size' => $this->file_size,
            'file_size_mb' => $this->file_size_in_mb,
            'mime_type' => $this->mime_type,
            'description' => $this->description,
            'url' => $this->url,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}