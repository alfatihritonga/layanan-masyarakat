<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'disaster_type_id',
        'description',
        'location_address',
        'incident_date',
        'urgency_level',
        'status',
        'victim_count',
        'damage_description',
        'contact_phone',
        'admin_notes',
        'rejection_reason',
        'verified_at',
        'verified_by',
        'resolved_at',
    ];

    protected $casts = [
        'incident_date' => 'datetime',
        'verified_at' => 'datetime',
        'resolved_at' => 'datetime',
        'victim_count' => 'integer',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function disasterType()
    {
        return $this->belongsTo(DisasterType::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function attachments()
    {
        return $this->hasMany(ReportAttachment::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function histories()
    {
        return $this->hasMany(ReportHistory::class);
    }

    public function comments()
    {
        return $this->hasMany(ReportComment::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeByUrgency($query, $level)
    {
        return $query->where('urgency_level', $level);
    }

    public function scopeByDisasterType($query, $typeId)
    {
        return $query->where('disaster_type_id', $typeId);
    }

    // Helper Methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isVerified()
    {
        return $this->status === 'verified';
    }

    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    public function isResolved()
    {
        return $this->status === 'resolved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function canBeEdited()
    {
        return $this->isPending();
    }

    public function canBeDeleted()
    {
        return $this->isPending();
    }
}