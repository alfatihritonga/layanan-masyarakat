<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Relawan extends Model
{
    use SoftDeletes;

    protected $table = 'relawan';

    protected $fillable = [
        'nama',
        'no_hp',
        'email',
        'alamat',
        'kecamatan',
        'kabupaten_kota',
        'status_ketersediaan',
        'skill',
        'tahun_bergabung',
    ];

    protected $casts = [
        'skill' => 'array',
        'tahun_bergabung' => 'integer',
    ];

    /* ==========================================================
     |  RELATIONS
     |==========================================================*/
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function activeAssignments()
    {
        return $this->hasMany(Assignment::class)->active();
    }

    /* ==========================================================
     |  QUERY SCOPES
     |==========================================================*/

    public function scopeAvailable(Builder $query)
    {
        return $query->where('status_ketersediaan', 'available');
    }

    public function scopeOnDuty(Builder $query)
    {
        return $query->where('status_ketersediaan', 'on_duty');
    }

    public function scopeByKabupaten(Builder $query, string $kabupaten)
    {
        return $query->where('kabupaten_kota', $kabupaten);
    }

    public function scopePublic(Builder $query)
    {
        return $query
            ->where('status_ketersediaan', '!=', 'unavailable')
            ->latest();
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('no_hp', 'like', "%{$search}%");
        });
    }

    /* ==========================================================
     |  ATTRIBUTE / HELPER
     |==========================================================*/

    public function getMasaKerjaAttribute(): int
    {
        return now()->year - $this->tahun_bergabung;
    }

    public function isAvailable(): bool
    {
        return $this->status_ketersediaan === 'available';
    }

    public function hasSkill(string $skill): bool
    {
        return in_array($skill, $this->skill ?? []);
    }

    /* ==========================================================
     |  DOMAIN LOGIC
     |==========================================================*/

    public function setOnDuty(): void
    {
        $this->update([
            'status_ketersediaan' => 'on_duty'
        ]);
    }

    public function setAvailable(): void
    {
        $this->update([
            'status_ketersediaan' => 'available'
        ]);
    }

    public function setUnavailable(): void
    {
        $this->update([
            'status_ketersediaan' => 'unavailable'
        ]);
    }
}
