<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'relawan_id',
        'assigned_by',
        'status',
        'notes',
        'assigned_at',
        'started_at',
        'completed_at',
        'completion_notes',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relations
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function relawan()
    {
        return $this->belongsTo(Relawan::class);
    }

    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['assigned', 'on_the_way', 'on_site']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Helper Methods
    public function isActive()
    {
        return in_array($this->status, ['assigned', 'on_the_way', 'on_site']);
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}