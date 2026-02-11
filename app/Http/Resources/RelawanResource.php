<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RelawanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'no_hp' => $this->no_hp,
            'email' => $this->email,
            'alamat' => $this->alamat,
            'kecamatan' => $this->kecamatan,
            'kabupaten_kota' => $this->kabupaten_kota,
            'status_ketersediaan' => $this->status_ketersediaan,
            'skill' => $this->skill,
            'tahun_bergabung' => $this->tahun_bergabung,
            
            // Include assignments jika diminta
            'assignments' => AssignmentResource::collection($this->whenLoaded('assignments')),
            'active_assignments' => AssignmentResource::collection($this->whenLoaded('activeAssignments')),
            
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}