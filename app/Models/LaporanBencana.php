<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaporanBencana extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'laporan_bencana';

    protected $fillable = [
        'user_id',
        'jenis_bencana',
        'deskripsi',
        'lokasi',
        'foto',
        'status',
        'tanggal_kejadian',
        'dampak',
    ];

    protected $casts = [
        'dampak'            => 'array',
        'tanggal_kejadian'  => 'date',
        'status'            => 'string',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function respon()
    {
        return $this->hasMany(ResponLaporan::class, 'laporan_id');
    }

    public function pengungsi()
    {
        return $this->hasMany(Pengungsi::class);
    }

    // Scopes
    public function scopeMine($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function timeline(): array
    {
        $timeline = [];

        // 1. Laporan dibuat
        $timeline[] = [
            'label' => 'Laporan Dikirim',
            'status' => 'pending',
            'time' => $this->created_at,
            'desc' => 'Laporan berhasil dikirim oleh masyarakat',
        ];

        // 2. Respon admin
        foreach ($this->respon as $respon) {
            if ($respon->status_respon === 'in_progress') {
                $timeline[] = [
                    'label' => 'Sedang Ditangani',
                    'status' => 'verified',
                    'time' => $respon->created_at,
                    'desc' => $respon->komentar,
                ];
            }

            if ($respon->status_respon === 'completed') {
                $timeline[] = [
                    'label' => 'Laporan Selesai',
                    'status' => 'resolved',
                    'time' => $respon->created_at,
                    'desc' => $respon->komentar,
                ];
            }
        }

        return collect($timeline)
            ->sortBy('time')
            ->values()
            ->all();
    }

}
