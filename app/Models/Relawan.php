<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relawan extends Model
{
    use HasFactory, SoftDeletes;

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
        'user_id',
    ];

    protected $casts = [
        'skill'                  => 'array',
        'status_ketersediaan'    => 'string',
        'tahun_bergabung'        => 'integer',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function respon()
    {
        return $this->belongsToMany(ResponLaporan::class, 'relawan_respon')
                    ->withPivot('peran')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status_ketersediaan', 'available');
    }
    
    public function scopeOnDuty($q)
    {
        return $q->where('status_ketersediaan', 'on_duty');
    }

}