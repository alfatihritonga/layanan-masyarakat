<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardStatisticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'total_reports' => $this->resource['total'],
            'pending_reports' => $this->resource['pending'],
            'verified_reports' => $this->resource['verified'],
            'in_progress_reports' => $this->resource['in_progress'],
            'resolved_reports' => $this->resource['resolved'],
            'rejected_reports' => $this->resource['rejected'],
            
            'by_urgency' => [
                'critical' => $this->resource['by_urgency']['critical'],
                'high' => $this->resource['by_urgency']['high'],
                'medium' => $this->resource['by_urgency']['medium'],
                'low' => $this->resource['by_urgency']['low'],
            ],
            
            'by_disaster_type' => $this->resource['by_disaster_type'],
            
            'recent_reports' => ReportListResource::collection($this->resource['recent_reports']),
        ];
    }
}