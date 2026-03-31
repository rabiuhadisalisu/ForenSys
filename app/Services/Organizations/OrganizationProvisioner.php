<?php

namespace App\Services\Organizations;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Str;

class OrganizationProvisioner
{
    /**
     * Create a starter lab organization for a newly registered user.
     */
    public function provisionPersonalLab(User $user, ?string $name = null): Organization
    {
        $displayName = $user->display_name ?: $user->name ?: 'Forensic Analyst';
        $organizationName = $name ?: sprintf('%s Lab', $displayName);
        $slugBase = Str::slug($organizationName) ?: 'forendesk-lab';

        $organization = Organization::create([
            'name' => $organizationName,
            'slug' => $this->uniqueSlug($slugBase),
            'code' => $this->uniqueCode(),
            'status' => 'active',
            'settings_json' => [
                'workspace' => [
                    'theme' => 'forendesk-dark',
                    'evidence_disk' => config('filesystems.default'),
                ],
            ],
        ]);

        $user->organizations()->attach($organization->getKey(), [
            'membership_status' => 'active',
            'is_default' => true,
            'joined_at' => now(),
            'invited_by' => $user->getKey(),
        ]);

        $user->forceFill([
            'active_organization_id' => $organization->getKey(),
        ])->saveQuietly();

        return $organization;
    }

    protected function uniqueSlug(string $base): string
    {
        $slug = $base;
        $counter = 1;

        while (Organization::query()->where('slug', $slug)->exists()) {
            $slug = sprintf('%s-%d', $base, $counter++);
        }

        return $slug;
    }

    protected function uniqueCode(): string
    {
        do {
            $code = 'FD-'.Str::upper(Str::random(8));
        } while (Organization::query()->where('code', $code)->exists());

        return $code;
    }
}
