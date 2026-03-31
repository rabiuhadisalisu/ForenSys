<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabScenarioAsset extends Model
{
    protected $casts = [
        'metadata_json' => 'array',
    ];

    public function labScenario(): BelongsTo
    {
        return $this->belongsTo(LabScenario::class);
    }
}
