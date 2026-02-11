<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RelawanListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'no_hp' => $this->no_hp,
            'email' => $this->email,
            'kabupaten_kota' => $this->kabupaten_kota,
            'status_ketersediaan' => $this->status_ketersediaan,
            'skill' => $this->skill,
        ];
    }
}