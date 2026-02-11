<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            
            // Basic Info
            'description' => $this->description,
            'location_address' => $this->location_address,
            'incident_date' => $this->incident_date?->format('Y-m-d H:i:s'),
            
            // Status & Urgency
            'urgency_level' => $this->urgency_level,
            'status' => $this->status,
            
            // Additional Data
            'victim_count' => $this->victim_count,
            'damage_description' => $this->damage_description,
            'contact_phone' => $this->contact_phone,
            
            // Admin Area
            'admin_notes' => $this->when(
                $request->user()?->isAdmin(),
                $this->admin_notes
            ),
            'rejection_reason' => $this->rejection_reason,
            
            // Tracking
            'verified_at' => $this->verified_at?->format('Y-m-d H:i:s'),
            'resolved_at' => $this->resolved_at?->format('Y-m-d H:i:s'),
            
            // Relations
            'user' => new UserResource($this->whenLoaded('user')),
            'disaster_type' => new DisasterTypeResource($this->whenLoaded('disasterType')),
            'verifier' => new UserResource($this->whenLoaded('verifier')),
            'attachments' => ReportAttachmentResource::collection($this->whenLoaded('attachments')),
            'assignments' => AssignmentResource::collection($this->whenLoaded('assignments')),
            'histories' => ReportHistoryResource::collection($this->whenLoaded('histories')),
            'comments' => ReportCommentResource::collection($this->whenLoaded('comments')),
            
            // Computed
            'can_be_edited' => $this->canBeEdited(),
            'can_be_deleted' => $this->canBeDeleted(),
            
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}