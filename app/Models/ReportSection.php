<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportSection extends Model
{
    protected $casts = [
        'is_included' => 'boolean',
    ];

    public function forensicReport(): BelongsTo
    {
        return $this->belongsTo(ForensicReport::class, 'report_id');
    }
}
