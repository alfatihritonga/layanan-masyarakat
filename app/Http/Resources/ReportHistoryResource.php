<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'field_name' => $this->field_name,
            'old_value' => $this->old_value,
            'new_value' => $this->new_value,
            'notes' => $this->notes,
            'changed_by' => new UserResource($this->whenLoaded('changer')),
            'changed_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}