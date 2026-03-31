<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasRoles;
    use Notifiable;

    protected string $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'email',
        'job_title',
        'timezone',
        'password',
        'active_organization_id',
        'last_seen_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $user): void {
            if (blank($user->ulid)) {
                $user->ulid = (string) Str::ulid();
            }

            if (blank($user->display_name)) {
                $user->display_name = $user->name;
            }
        });
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class)
            ->using(OrganizationMembership::class)
            ->withPivot(['membership_status', 'is_default', 'joined_at', 'invited_by'])
            ->withTimestamps();
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(OrganizationMembership::class);
    }

    public function activeOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'active_organization_id');
    }

    public function caseMemberships(): HasMany
    {
        return $this->hasMany(CaseMember::class);
    }

    public function investigationCases(): BelongsToMany
    {
        return $this->belongsToMany(InvestigationCase::class, 'case_members')
            ->using(CaseMember::class)
            ->withPivot(['member_role', 'access_level', 'assigned_by', 'assigned_at'])
            ->withTimestamps();
    }

    public function ledCases(): HasMany
    {
        return $this->hasMany(InvestigationCase::class, 'lead_analyst_id');
    }

    public function caseNotes(): HasMany
    {
        return $this->hasMany(CaseNote::class);
    }

    public function evidenceNotes(): HasMany
    {
        return $this->hasMany(EvidenceNote::class);
    }

    public function toolRuns(): HasMany
    {
        return $this->hasMany(ToolRun::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    public function labAssignments(): HasMany
    {
        return $this->hasMany(LabAssignment::class);
    }

    public function assignmentSubmissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function forensicReports(): HasMany
    {
        return $this->hasMany(ForensicReport::class, 'created_by');
    }

    public function workspaceNotifications(): HasMany
    {
        return $this->hasMany(WorkspaceNotification::class);
    }

    public function scopeInOrganization($query, Organization|int $organization): mixed
    {
        $organizationId = $organization instanceof Organization ? $organization->getKey() : $organization;

        return $query->whereHas('organizations', fn ($builder) => $builder->whereKey($organizationId));
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_seen_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
