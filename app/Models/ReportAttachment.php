<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'mime_type',
        'description',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    // Relations
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    // Helper Methods
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    public function isImage()
    {
        return $this->file_type === 'image';
    }

    public function isVideo()
    {
        return $this->file_type === 'video';
    }

    public function getFileSizeInMbAttribute()
    {
        return round($this->file_size / 1024 / 1024, 2);
    }
}