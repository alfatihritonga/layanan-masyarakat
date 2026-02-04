<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengungsi extends Model
{
    use HasFactory;

    protected $table = 'pengungsi';

    protected $fillable = [
        'laporan_id',
        'jumlah_orang',
        'jumlah_anak',
        'jumlah_lansia',
        'lokasi_pengungsian',
        'kebutuhan_utama',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    protected $casts = [
        'jumlah_orang'          => 'integer',
        'jumlah_anak'           => 'integer',
        'jumlah_lansia'         => 'integer',
        'kebutuhan_utama'       => 'array',
        'tanggal_mulai'         => 'date',
        'tanggal_selesai'       => 'date',
    ];

    // Relasi
    public function laporan()
    {
        return $this->belongsTo(LaporanBencana::class);
    }
}