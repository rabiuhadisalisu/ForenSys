<?php

namespace App\Models\Concerns;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait OrganizationScoped
{
    protected static function bootOrganizationScoped(): void
    {
        static::creating(function ($model): void {
            if (blank($model->organization_id) && auth()->check()) {
                $model->organization_id = auth()->user()->active_organization_id;
            }
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function scopeForActiveOrganization(Builder $query, ?int $organizationId = null): Builder
    {
        $organizationId ??= app()->bound('activeOrganization')
            ? app('activeOrganization')->getKey()
            : auth()->user()?->active_organization_id;

        return $organizationId
            ? $query->where($this->qualifyColumn('organization_id'), $organizationId)
            : $query;
    }

    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        $field ??= $this->getRouteKeyName();

        $query->where($this->qualifyColumn($field), $value);

        $organizationId = app()->bound('activeOrganization')
            ? app('activeOrganization')->getKey()
            : auth()->user()?->active_organization_id;

        if ($organizationId) {
            $query->where($this->qualifyColumn('organization_id'), $organizationId);
        }

        return $query;
    }
}
