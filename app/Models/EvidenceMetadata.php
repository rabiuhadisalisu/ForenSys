<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvidenceMetadata extends Model
{
    protected $table = 'evidence_metadata';

    protected $casts = [
        'metadata_json' => 'array',
        'summary_json' => 'array',
        'extracted_at' => 'datetime',
    ];

    public function evidenceItem(): BelongsTo
    {
        return $this->belongsTo(EvidenceItem::class);
    }
}
