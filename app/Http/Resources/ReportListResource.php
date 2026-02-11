<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportListResource extends JsonResource
{
    /**
     * Resource untuk list report (tanpa detail lengkap)
     * Lebih ringan untuk performance
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'location_address' => $this->location_address,
            'incident_date' => $this->incident_date?->format('Y-m-d H:i:s'),
            'urgency_level' => $this->urgency_level,
            'status' => $this->status,
            'victim_count' => $this->victim_count,
            
            // Relations (minimal)
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'disaster_type' => [
                'id' => $this->disasterType->id,
                'name' => $this->disasterType->name,
                'color' => $this->disasterType->color,
            ],
            
            // Count
            'attachments_count' => $this->attachments->count(),
            'assignments_count' => $this->assignments->count(),
            
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}