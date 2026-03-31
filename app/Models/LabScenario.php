<?php

namespace App\Models;

use App\Models\Concerns\HasPublicUlid;
use App\Models\Concerns\OrganizationScoped;
use Database\Factories\LabScenarioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabScenario extends Model
{
    /** @use HasFactory<LabScenarioFactory> */
    use HasFactory;
    use HasPublicUlid;
    use OrganizationScoped;
    use SoftDeletes;

    protected $casts = [
        'hints_json' => 'array',
        'answer_key_json' => 'array',
        'published_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(LabScenarioAsset::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(LabAssignment::class);
    }
}
