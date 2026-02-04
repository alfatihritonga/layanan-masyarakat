<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponLaporan extends Model
{
    use HasFactory;

    protected $table = 'respon_laporan';

    protected $fillable = [
        'laporan_id',
        'user_id',
        'komentar',
        'status_respon',
        'tindakan',
    ];

    protected $casts = [
        'tindakan' => 'array',
    ];

    // Relasi
    public function laporan()
    {
        return $this->belongsTo(LaporanBencana::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function relawan()
    {
        return $this->belongsToMany(Relawan::class, 'relawan_respon')
                    ->withPivot('peran')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status_respon', 'completed');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status_respon', 'in_progress');
    }
}