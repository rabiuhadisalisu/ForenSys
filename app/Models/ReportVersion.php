<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportVersion extends Model
{
    protected $casts = [
        'snapshot_json' => 'array',
    ];

    public function forensicReport(): BelongsTo
    {
        return $this->belongsTo(ForensicReport::class, 'report_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
