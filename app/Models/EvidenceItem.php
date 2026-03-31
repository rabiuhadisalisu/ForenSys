<?php

namespace App\Models;

use App\Models\Concerns\HasPublicUlid;
use App\Models\Concerns\OrganizationScoped;
use Database\Factories\EvidenceItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvidenceItem extends Model
{
    /** @use HasFactory<EvidenceItemFactory> */
    use HasFactory;
    use HasPublicUlid;
    use OrganizationScoped;
    use SoftDeletes;

    protected $casts = [
        'is_quarantined' => 'boolean',
        'quarantined_at' => 'datetime',
    ];

    public function investigationCase(): BelongsTo
    {
        return $this->belongsTo(InvestigationCase::class, 'case_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function hashes(): HasMany
    {
        return $this->hasMany(EvidenceHash::class);
    }

    public function metadataRecords(): HasMany
    {
        return $this->hasMany(EvidenceMetadata::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(EvidenceNote::class);
    }

    public function custodyLogs(): HasMany
    {
        return $this->hasMany(CustodyLog::class);
    }

    public function toolRuns(): HasMany
    {
        return $this->hasMany(ToolRun::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    public function labels(): MorphToMany
    {
        return $this->morphToMany(Label::class, 'labelable');
    }
}
