<?php

namespace App\Models;

use App\Models\Concerns\HasPublicUlid;
use Database\Factories\OrganizationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    /** @use HasFactory<OrganizationFactory> */
    use HasFactory;
    use HasPublicUlid;
    use SoftDeletes;

    protected $casts = [
        'settings_json' => 'array',
    ];

    public function memberships(): HasMany
    {
        return $this->hasMany(OrganizationMembership::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(OrganizationMembership::class)
            ->withPivot(['membership_status', 'is_default', 'joined_at', 'invited_by'])
            ->withTimestamps();
    }

    public function investigationCases(): HasMany
    {
        return $this->hasMany(InvestigationCase::class);
    }

    public function evidenceItems(): HasMany
    {
        return $this->hasMany(EvidenceItem::class);
    }

    public function forensicReports(): HasMany
    {
        return $this->hasMany(ForensicReport::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    public function toolRuns(): HasMany
    {
        return $this->hasMany(ToolRun::class);
    }

    public function labScenarios(): HasMany
    {
        return $this->hasMany(LabScenario::class);
    }

    public function labAssignments(): HasMany
    {
        return $this->hasMany(LabAssignment::class);
    }

    public function labels(): HasMany
    {
        return $this->hasMany(Label::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(SystemSetting::class);
    }

    public function processingJobs(): HasMany
    {
        return $this->hasMany(ProcessingJob::class);
    }

    public function workspaceNotifications(): HasMany
    {
        return $this->hasMany(WorkspaceNotification::class);
    }
}
