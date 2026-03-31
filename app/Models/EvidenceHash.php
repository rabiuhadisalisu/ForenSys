<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvidenceHash extends Model
{
    protected $casts = [
        'is_primary' => 'boolean',
        'computed_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function evidenceItem(): BelongsTo
    {
        return $this->belongsTo(EvidenceItem::class);
    }

    public function computedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'computed_by');
    }
}
