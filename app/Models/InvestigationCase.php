<?php

namespace App\Models;

use App\Models\Concerns\HasPublicUlid;
use App\Models\Concerns\OrganizationScoped;
use Database\Factories\InvestigationCaseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvestigationCase extends Model
{
    /** @use HasFactory<InvestigationCaseFactory> */
    use HasFactory;
    use HasPublicUlid;
    use OrganizationScoped;
    use SoftDeletes;

    protected $table = 'cases';

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function leadAnalyst(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lead_analyst_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'case_members')
            ->using(CaseMember::class)
            ->withPivot(['member_role', 'access_level', 'assigned_by', 'assigned_at'])
            ->withTimestamps();
    }

    public function caseMemberships(): HasMany
    {
        return $this->hasMany(CaseMember::class, 'case_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(CaseNote::class, 'case_id');
    }

    public function timelineEvents(): HasMany
    {
        return $this->hasMany(CaseTimelineEvent::class, 'case_id');
    }

    public function evidenceItems(): HasMany
    {
        return $this->hasMany(EvidenceItem::class, 'case_id');
    }

    public function forensicReports(): HasMany
    {
        return $this->hasMany(ForensicReport::class, 'case_id');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'case_id');
    }

    public function labels(): MorphToMany
    {
        return $this->morphToMany(Label::class, 'labelable');
    }
}
