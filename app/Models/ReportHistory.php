<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'changed_by',
        'field_name',
        'old_value',
        'new_value',
        'notes',
    ];

    // Relations
    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}